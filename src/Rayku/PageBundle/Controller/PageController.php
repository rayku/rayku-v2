<?php

namespace Rayku\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Rayku\UserBundle\Form\Type\RegistrationAndTutorProfileFormType;
use Rayku\ApiBundle\Form\UserSettingType;
use Rayku\ApiBundle\Entity\Tutor;
use Rayku\ApiBundle\Form\TutorType;

use Rayku\ApiBundle\Entity\User;

class PageController extends Controller
{
	/**
	 * @Route("/about", name="rayku_page_about")
	 * @Template
	 */
	public function aboutAction(){ }
	
	/**
	 * @Route("/onboarding", name="rayku_page_tutor_onboarding")
	 * @Template
	 */
	public function onboardingAction() { }
	
	/**
	 * @Route("/legal", name="rayku_legal_page")
	 * @Template
	 */
	public function legalAction() { }
	
	/**
	 * @Route("/getwhiteboard", name="rayku_page_whiteboard_iframe")
	 */
	public function whiteboardIframeAction()
	{
		$result = file_get_contents($_POST['address']);
		return $result;
	}

	/**
	 * @Route("/", name="rayku_page_homepage")
	 * @Route("/ask", name="rayku_page_homepage_minimized_funnel")
	 * @Template
	 */
	public function indexAction()
	{
		if($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')){
			return $this->redirect($this->generateUrl('rayku_page_dashboard'));
		}
		return array('form' => $this->container->get('fos_user.registration.form'));
	}	
	
	/**
	 * @Route("/become-a-tutor", name="rayku_page_become_a_tutor")
	 * @Template
	 */
	public function becomeAction()
	{
		$user = new User();
		$registrationform = $this->createForm(new RegistrationAndTutorProfileFormType(get_class($user)), $user)->createView();
		return array('registrationform' => $registrationform);
	}
	
	/**
	 * @Route("/session/{id}/rate", requirements={"id" = "\d+"}, name="rayku_session_rate")
	 */
	public function rateSessionAction()
	{
		die('not implemented yet');
	}
	
	/**
	 * @Route("/register/confirmed", name="rayku_register_confirmed")
	 * @Route("/dashboard", name="rayku_page_dashboard")
	 * @Template("RaykuPageBundle:Page:dashboard2.html.twig")
	 */
	public function dashboardAction()
	{		
		return array('user' => $this->getUser());
	}
	
	/**
	 * @Route("/tutor/{username}/public", name="rayku_tutor_show")
	 * @Template()
	 */
	public function showTutorAction($username)
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
	 * @deprecated
	 * @Route("/new", name="rayku_tutor_new")
	 * @Route("/edit", name="rayku_tutor_edit")
	 * @Template()
	 */
	public function createTutorAction()
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
