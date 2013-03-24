<?php

namespace Rayku\TutorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
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

        $entities = $em->getRepository('RaykuTutorBundle:Tutor')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Tutor entity.
     *
     * @Route("/{id}/show", name="rayku_tutor_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RaykuTutorBundle:Tutor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tutor entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Creates a new Tutor entity.
     *
     * @Route("/create", name="rayku_tutor_create")
     * @Method("POST")
     * @Template("RaykuTutorBundle:Tutor:new.html.twig")
     */
    public function newAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$entity = $em->getRepository('RaykuTutorBundle:Tutor')->findOneByUser($this->getUser());
    	if(!$entity){
    		$entity = new Tutor();
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
    	
    		return $this->redirect($this->generateUrl('rayku_tutor_show', array('id' => $entity->getId())));
    	}
    	
    	return array(
    		'entity' => $entity,
    		'form'   => $form->createView(),
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
    	$entity = $em->getRepository('RaykuTutorBundle:Tutor')->findOneByUser($this->getUser());
    	if(!$entity){
    		$entity = new Tutor();
    		$entity->setUser($this->getUser());
    	}
    	
    	$form   = $this->createForm(new TutorType(), $entity);
    
    	return array(
    		'entity' => $entity,
    		'form'   => $form->createView(),
    	);
    }
}
