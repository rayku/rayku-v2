<?php

namespace Rayku\ApiBundle\Controller;

use Rayku\ApiBundle\Entity\Invoice;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\SecurityExtraBundle\Annotation\SecureParam;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Rayku\ApiBundle\Entity\CreditCard;
use Rayku\ApiBundle\Entity\User;
use Rayku\ApiBundle\Entity\Transaction;
use Rayku\ApiBundle\Form\CreditCardType;
use Rayku\ApiBundle\Form\InvoiceType;
/**
 * RestCreditCard controller.
 */
class CreditCardController extends Controller
{
	/**
	 * @Secure(roles="ROLE_USER")
	 * @ApiDoc(
	 *   statusCodes={
     *     200="Returned when successful",
     *     400="Returned when there is an error",
     *     401="Returned when unauthorized"
     *   },
	 *   description="Chardge a Credit Card",
	 *   input="Rayku\ApiBundle\Form\InvoiceType"
	 * )
	 * @param \Rayku\ApiBundle\Entity\CreditCard $card
	 */
	public function postCreditcardChargeAction(CreditCard $card)
	{
		$user = $this->getUser();
		
		if($user !== $card->getUser()){
			throw new AccessDeniedException();
		}
		
		$invoice = new Invoice();
		$invoice->setUser($user);
		$form = $this->createForm(new InvoiceType(), $invoice)->bind($this->getRequest());
		
		if($form->isValid()){
			$em = $this->getDoctrine()->getManager();
			$em->persist($invoice);
			
			$gateway = $this->get('rayku_payment_gateway')->setApiKey($this->container->getParameter('payment.gateway.api_key'));
			$response = $gateway->purchase(array(
				'amount' => $invoice->getCost(),
				'currency' => 'CAD',
				'cardReference' => $card->getReference()		
			))->send();
			
			$transaction = new Transaction();
			$transaction->setUser($user);
			$transaction->setCard($card);
			$transaction->setCost($invoice->getCost());
			$transaction->setReference($response->getTransactionReference());
			$transaction->setData(serialize($response->getData()));
			
			if($response->isSuccessful()){
				$transaction->setStatus('successful');
				$invoice->setStatus('successful');
				$em->persist($invoice);
				$em->persist($transaction);
				$em->flush();
				
				return array('success' => true, 'invoice' => $invoice);
			}
			
			$transaction->setStatus('failed');
			$em->persist($transaction);
			$em->flush();
			
			return array('success' => false, 'invoice' => $invoice, 'message' => $response->getMessage());
		}else{
			\Doctrine\Common\Util\Debug::dump($form->getErrorsAsString());
			die(__LINE__.' '.__FILE__);
		}
		return array('form' => $form, 'success' => false);
	}
	
	/**
	 * @Secure(roles="ROLE_USER")
	 * @ApiDoc(
	 *   statusCodes={
     *     200="Returned when successful",
     *     400="Returned when there is an error",
     *     401="Returned when unauthorized"
     *   },
	 *   description="Create a new Credit Card record",
	 *   resource=true,
	 *   input="Rayku\ApiBundle\Form\CreditCardType"
	 * )
	 */
	public function postCreditcardAction()
	{
		$form = $this->createForm(new CreditCardType())->bind($this->getRequest());
		
		if($form->isValid()){
			$params['card'] = $form->getData();
			$gateway = $this->get('rayku_payment_gateway')->setApiKey($this->container->getParameter('payment.gateway.api_key'));
			$response = $gateway->createCard($params)->send();

			if($response->isSuccessful()){
				$creditCard = new CreditCard();
				$creditCard->setReference($response->getCardReference());
				
				$data = $response->getData();
				$creditCard->setData(serialize($data['active_card']));
				$creditCard->setDigits($data['active_card']['last4']);
				$creditCard->setMonth($data['active_card']['exp_month']);
				$creditCard->setYear($data['active_card']['exp_year']);
				$creditCard->setType($data['active_card']['type']);
				$creditCard->setName($data['active_card']['name']);
				$creditCard->setUser($this->getUser());

				$em = $this->getDoctrine()->getManager();
				$em->persist($creditCard);
				$em->flush();
				
				// creating the ACL
				$aclProvider = $this->get('security.acl.provider');
				$objectIdentity = ObjectIdentity::fromDomainObject($creditCard);
				$acl = $aclProvider->createAcl($objectIdentity);
				 
				// retrieving the security identity of the currently logged-in user
				$securityContext = $this->get('security.context');
				$user = $securityContext->getToken()->getUser();
				$securityIdentity = UserSecurityIdentity::fromAccount($user);
				 
				// grant owner access
				$acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
				$aclProvider->updateAcl($acl);
				
				return array('success' => true, 'card' => $creditCard);
			}else{
				return array('success' => false, 'message' => $response->getMessage());
			}
		}
		return $form;
	}
}

