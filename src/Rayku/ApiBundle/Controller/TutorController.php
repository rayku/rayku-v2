<?php

namespace Rayku\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

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
	 *   description="Delete a tutor account"
	 * )
	 */
	public function deleteTutorsAction(Tutor $entity)
	{
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
	 *   description="Get online tutors"
	 * )
	 */
	public function getTutorsAction()
	{
		$em = $this->getDoctrine()->getManager();
		$entities = $em->getRepository('RaykuApiBundle:Tutor')->findOnlineTutors(Tutor::expire_online);
		return array('entities' => $entities);
	}
	
	/**
	 * @View()
	 * @ApiDoc(
	 *   description="Create/update tutor object",
	 *   resource=true,
	 *   input="Rayku\ApiBundle\Form\TutorType"
	 * )
	 */
	public function postTutorsAction()
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
		 
		// Since we cleared doctrine above need to get a new user entity from the DB
		$user = $em->getRepository('RaykuApiBundle:User')->find($this->getUser()->getId());
		$entity->setUser($user);
		return $this->processForm($entity);
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

