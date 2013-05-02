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
use Rayku\ApiBundle\Form\UserSettingType;
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
	 * Lists all Tutor entities.
	 *
	 * @Route("/", name="rayku_tutor")
	 * @Template()
	 * @todo deprecate in lieu of api get tutor
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();
		$entities = $em->getRepository('RaykuApiBundle:Tutor')->findOnlineTutors(Tutor::expire_online, $this->getUser()->getId());
		return array('entities' => $entities);
	}
	
    /**
     * Finds and displays a Tutor entity.
     *
     * @Route("/{username}/public", name="rayku_tutor_show")
     * @Template()
     * 
     * @param \Rayku\ApiBundle\Entity\Tutor $tutor
     */
    public function showAction($username)
    {
        //check if user requested is a tutor, display public profile if isTutor, else redirect to Dashboard
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('RaykuApiBundle:User')->findOneByUsername($username);
        if(!$user){
            return $this->redirect($this->generateUrl('rayku_page_dashboard'));
        }
        if(!$user->getIsTutor()){
            return $this->redirect($this->generateUrl('rayku_page_dashboard'));
        }
        $entity = $em->getRepository('RaykuApiBundle:User')->findOneByUsername($username)->getTutor();
        
        $userSettingForm = $this->createForm(new UserSettingType(), $this->getUser());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tutor entity.');
        }
        else{
            return array(
                'entity'      => $entity,
            	'usersettingform' => $userSettingForm->createView()
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
