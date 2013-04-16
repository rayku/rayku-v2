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
use Rayku\ApiBundle\Entity\Tutor;
use Rayku\ApiBundle\Form\TutorType;

use Rayku\ApiBundle\Entity\Session;
use Rayku\ApiBundle\Entity\SessionTutors;
use Rayku\ApiBundle\Form\SessionType;

/**
 * Tutor controller.
 *
 * @Route("/tutor")
 */
class TutorController extends Controller
{
    /**
     * Finds and displays a Tutor entity.
     *
<<<<<<< HEAD
     * @Route("/{username}/public", name="rayku_tutor_show")
=======
     * @Route("/{username}/show", name="rayku_tutor_show")
>>>>>>> Refactor bundle structure
     * @Template()
     * 
     * @param \Rayku\ApiBundle\Entity\Tutor $tutor
     */
    public function showAction($username)
    {
        //check if user requested is a tutor, display public profile if isTutor, else redirect to Dashboard
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('RaykuUserBundle:User')->findOneByUsername($username);
        if(!$user){
            return $this->redirect($this->generateUrl('rayku_page_dashboard'));
        }
        if(!$user->getIsTutor()){
            return $this->redirect($this->generateUrl('rayku_page_dashboard'));
        }
        $entity = $em->getRepository('RaykuUserBundle:User')->findOneByUsername($username)->getTutor();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tutor entity.');
        }
        else{
            return array(
                'entity'      => $entity,
            );
        }
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
    	
    	$entity = $em->getRepository('RaykuApiBundle:Tutor')->findOneByUser($this->getUser());
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
