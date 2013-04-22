<?php

namespace Rayku\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\SecurityExtraBundle\Annotation\SecureParam;

use Rayku\ApiBundle\Entity\Tutor;
use Rayku\ApiBundle\Form\TutorType;
/**
 * RestTutor controller.
 */
class TutorController extends Controller
{
	
	/**
	 * @View()
	 * @ApiDoc(
	 *   statusCodes={
     *     200="Returned when successful",
     *     403="Returned when the user is not authorized"
     *   },
	 *   description="Delete a tutor account"
	 * )
	 * @todo setup / configure ACL
	 */
	public function deleteTutorsAction(Tutor $entity)
	{
		if($entity->getUser() != $this->getUser()){
			throw new AccessDeniedException();
		}
		$em = $this->getDoctrine()->getManager();
		$em->remove($entity);
		$em->flush();
		 
		return new Response(
			json_encode(array('success' => true)),
			200,
			array('Content-Type'=>'application/json')
		);
	}
	
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
	public function getTutorAction(Tutor $entity)
	{
		return $entity;
	}
	
	/**
	 * @View()
	 * @ApiDoc(
	 *   statusCodes={
     *     200="Returned when successful"
     *   },
	 *   description="Get online tutors"
	 * )
	 */
	public function getTutorsAction()
	{
		$em = $this->getDoctrine()->getManager();
		$entities = $em->getRepository('RaykuApiBundle:Tutor')->findOnlineTutors(Tutor::expire_online);
		return $entities;
	}
	
	/**
	 * @View()
	 * @ApiDoc(
	 *   statusCodes={
     *     200="Returned when successful",
     *     400="Returned when there is an error"
     *   },
	 *   description="Create/update tutor object",
	 *   resource=true,
	 *   input="Rayku\ApiBundle\Form\TutorType"
	 * )
	 */
	public function postTutorsAction()
	{
		$entity = $this->getTutor();
		 
		// Since we cleared doctrine above need to get a new user entity from the DB
		$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository('RaykuApiBundle:User')->find($this->getUser()->getId());
		$entity->setUser($user);
		return $this->processForm($entity);
	}
	
	/**
	 * @todo http://symfony.com/doc/2.1/cookbook/form/dynamic_form_modification.html#dynamic-generation-for-submitted-forms
	 * @View()
	 * @ApiDoc(
	 *   description="Patch a tutor record",
	 *   input="Rayku\ApiBundle\Form\TutorType"
	 * )
	 */
	public function patchTutorsAction()
	{
		$entity = $this->getTutor();
		
		if(null === $entity->getId() && $entity->getUser() != $this->getUser()){
			throw new AccessDeniedException();
		}
		
		$valid = false;
		foreach($this->get('request')->request->all() as $k => $v){
			if(in_array($k, array('gtalk_email'))){
				$method = 'set' . preg_replace('/(?:^|_)(.?)/e',"strtoupper('$1')",$k);
				if(method_exists($entity, $method)){
					$entity->$method($v);
					$valid = true;
				}
			}
		}
		
		if(!$valid){
			return array(
				'success' => false, 
				'message' => 'Invalid parameters'
			);
		}
		
		$errors = $this->get('validator')->validate($entity);
		
		if(count($errors) > 0){
			$errorOutput = array();
			foreach($errors as $error){
				$errorOutput[$error->getPropertyPath()] = $error->getMessage();
			}
			return array(
				'success' => false,
				'form' => $errorOutput	
			);
		}
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();
		
		return array(
			'success' => true,
			'entity' => $entity	
		);
	}
	
	private function getTutor()
	{
		$em = $this->getDoctrine()->getManager();
		$em->getFilters()->disable('soft_deleteable');
		$em->clear();
		
		$entity = $em->getRepository('RaykuApiBundle:Tutor')->findOneByUser($this->getUser());
		if(!$entity){
			$entity = new Tutor();
		}else{
			$entity->setDeletedAt(NULL);
		}
		return $entity;
	}
	
	private function processForm(Tutor $entity)
	{
		$request = $this->getRequest();
		$new = (null === $entity->getId()) ? true : false;
		$form = $this->createForm(new TutorType(), $entity);
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
		 
		if(null !== $entity->getGtalkEmail()){
			require_once $this->get('kernel')->getRootDir() .'/../bin/BotServiceProvider.class.php';
			\BotServiceProvider::createFor('http://10.180.146.105:8892/add/'.$entity->getGtalkEmail())->getContent();
		}
		 
		return array(
			'entity' => $entity,
			'form'   => $form,
		);
	}
}

