<?php

namespace Rayku\TutorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\SecureParam;
use Rayku\TutorBundle\Entity\Tutor;
use Rayku\TutorBundle\Form\TutorType;

use Rayku\SessionBundle\Entity\Session;
use Rayku\SessionBundle\Entity\SessionTutors;
use Rayku\SessionBundle\Form\SessionType;

/**
 * Tutor controller.
 *
 * @Route("/tutor")
 */
class TutorController extends Controller
{
    /**
     * Lists all Tutor entities.
     *
     * @Route("/", name="rayku_tutor")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('RaykuTutorBundle:Tutor')->findOnlineTutors(Tutor::expire_online);
        return array('entities' => $entities,);
    }

    /**
     * Finds and displays a Tutor entity.
     *
     * @Route("/{id}/show", name="rayku_tutor_show")
     * @Template()
     * 
     * @param \Rayku\TutorBundle\Entity\Tutor $tutor
     */
    public function showAction(Tutor $entity)
    {
        return array(
            'entity'      => $entity,
        );
    }
    
    /**
     * Delete a tutor record
     * 
     * @Route("/{id}/delete", name="rayku_tutor_delete")
     * @SecureParam(name="entity", permissions="DELETE")
     * 
     * @param \Rayku\TutorBundle\Entity\Tutor $entity
     */
    public function deleteAction(Tutor $entity)
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
     * Creates a new Tutor entity.
     *
     * @Route("/save", name="rayku_tutor_save")
     * @Method("POST")
     * @Template("RaykuTutorBundle:Tutor:create.html.twig")
     */
    public function newAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$em->getFilters()->disable('soft_deleteable');
    	$em->clear();
    	    	
    	$entity = $em->getRepository('RaykuTutorBundle:Tutor')->findOneByUser($this->getUser());
    	if(!$entity){
    		$entity = new Tutor();
    	}else{
    		$entity->setDeletedAt(NULL);
    	}
    	
    	$entity->setUser($this->getUser());
        return $this->processForm($request, $entity);
    }
    
    private function processForm(Request $request, Tutor $entity)
    {
    	$new = (null === $entity->getId()) ? true : false;
    	$form = $this->createForm(new TutorType(), $entity);
    	$form->bind($request);
    	
    	if ($form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($entity);
	    	$em->persist($this->getUser());
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
    
    /**
     * Displays a form to create a new Tutor entity.
     *
     * @Route("/new", name="rayku_tutor_new")
     * @Route("/edit", name="rayku_tutor_edit")
     * @Template()
     */
    public function createAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$em->getFilters()->disable('soft_deleteable');
    	$em->clear();
    	
    	$entity = $em->getRepository('RaykuTutorBundle:Tutor')->findOneByUser($this->getUser());
    	if(!$entity){
    		$entity = new Tutor();
    	}
    	$entity->setUser($this->getUser());
    	
    	$form   = $this->createForm(new TutorType(), $entity);
    
    	return array(
    		'entity' => $entity,
    		'form'   => $form->createView(),
    	);
    }

}
