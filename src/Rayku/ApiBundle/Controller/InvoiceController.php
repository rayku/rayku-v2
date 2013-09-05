<?php

namespace Rayku\ApiBundle\Controller;

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
use Rayku\ApiBundle\Entity\Invoice;
use Rayku\ApiBundle\Form\InvoiceType;
/**
 * RestInvoice controller.
 */
class InvoiceController extends Controller
{
	
	/**
	 * @Secure(roles="ROLE_USER")
	 * @View(serializerGroups={"invoice.details"})
	 * @ApiDoc(
	 *   statusCodes={
     *     200="Returned when successful"
     *   },
	 *   description="Get a invoice record"
	 * )
	 */
	public function getInvoicesAction(Invoice $invoice)
	{
		return $invoice;
	}
	
	/**
	 * @Secure(roles="ROLE_USER")
	 * @View(serializerGroups={"invoice.details"})
	 * @ApiDoc(
	 *   statusCodes={
     *     200="Returned when successful",
     *     400="Returned when there is an error"
     *   },
	 *   description="Create a new Invoice record",
	 *   resource=true,
	 *   input="Rayku\ApiBundle\Form\InvoiceType"
	 * )
	 */
	public function postInvoicesAction()
	{
		$invoice = new Invoice();
		$invoice->setUser($this->getUser());
		return $this->processForm($invoice);
	}
	
	private function processForm(Invoice $invoice){
		$new = (null === $invoice->getId()) ? true : false;
		$form = $this->createForm(new InvoiceType(), $invoice)->bind($this->getRequest());
		
		if($form->isValid()){
			$em = $this->getDoctrine()->getManager();
			$em->persist($invoice);
			$em->flush();
			
			if($new){
				// creating the ACL
				$aclProvider = $this->get('security.acl.provider');
				$objectIdentity = ObjectIdentity::fromDomainObject($invoice);
				$acl = $aclProvider->createAcl($objectIdentity);
				 
				// retrieving the security identity of the currently logged-in user
				$securityContext = $this->get('security.context');
				$user = $securityContext->getToken()->getUser();
				$securityIdentity = UserSecurityIdentity::fromAccount($user);
				 
				// grant owner access
				$acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
				$aclProvider->updateAcl($acl);
			}
			
			return array('success' => true, 'invoice' => $invoice);
		}
		return $form;
	}
}

