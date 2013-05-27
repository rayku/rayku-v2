<?php

namespace Rayku\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\SecurityExtraBundle\Annotation\SecureParam;

use Rayku\ApiBundle\Entity\Order;
use Rayku\ApiBundle\Form\OrderType;
/**
 * RestOrder controller.
 */
class OrderController extends Controller
{
	/**
	 * @View()
	 * @ApiDoc(
	 *   statusCodes={
     *     200="Returned when successful"
     *   },
	 *   description="Get a tutor record",
	 *   output="Rayku\ApiBundle\Entity\Tutor"
	 * )
	 */
	public function getOrderAction(Order $entity)
	{
		return $entity;
	}
	
	/**
	 * @View()
	 * @ApiDoc(
	 *   statusCodes={
     *     200="Returned when successful",
     *     400="Returned when there is an error"
     *   },
	 *   description="Create/update order object",
	 *   resource=true,
	 *   input="Rayku\ApiBundle\Form\OrderType"
	 * )
	 */
	public function postOrdersAction()
	{
		$entity = new Order();
		$entity->setUser($this->getUser());
		return $this->processForm($entity);
	}
	
	private function processForm(Order $entity)
	{
		$request = $this->getRequest();
		$new = (null === $entity->getId()) ? true : false;
		$form = $this->createForm(new OrderType(), $entity);
		$form->bind($request);
		 
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();
	
			if($new){
				// creating the ACL
				$aclProvider = $this->get('security.acl.provider');
				$objectIdentity = ObjectIdentity::fromDomainObject($entity);
				$acl = $aclProvider->createAcl($objectIdentity);
		   
				// retrieving the security identity of the currently logged-in user
				$securityContext = $this->get('security.context');
				$user = $securityContext->getToken()->getUser();
				$securityIdentity = UserSecurityIdentity::fromAccount($user);
		   
				// grant owner access
				$acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
				$aclProvider->updateAcl($acl);
			}
		}
		 
		return array(
			'entity' => $entity,
			'form'   => $form,
		);
	}
}

