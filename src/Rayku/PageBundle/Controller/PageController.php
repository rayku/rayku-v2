<?php

namespace Rayku\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Rayku\UserBundle\Form\Type\RegistrationAndTutorProfileFormType;
use Rayku\ApiBundle\Form\UserSettingType;
use Rayku\ApiBundle\Form\TutorType;
use Rayku\ApiBundle\Form\RateSessionType;
use Rayku\ApiBundle\Entity\Tutor;
use Rayku\ApiBundle\Entity\Session;

use Rayku\ApiBundle\Entity\User;

class PageController extends Controller
{
	/**
	 * @Route("/{page}/login", name="dynamic_login_page")
	 */
	public function dynamicLoginAction($page){
		$pageData = array(
			'ryerson' => array('redirect' => '/#/course/math_center/view', 'title' => 'Ryerson University'),
			'uoft' => array('redirect' => '/#/course/uoftmathcenter/view', 'title' => 'University of Toronto'),
			'kangaroo' => array('redirect' => '/#/course/mathcenter/view', 'title' => 'Canadian Math Kangaroo Contest')
		);
		
		if(!isset($pageData[$page])){
			return $this->createNotFoundException();
		}else{
			$redirect = $pageData[$page]['redirect'];
			$title = $pageData[$page]['title'];
		}
		
		if($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')){
			return $this->redirect(urldecode($redirect));
		}else{
			return $this->render('RaykuPageBundle:Page:dynamic.html.twig', array('redirect' => $redirect, 'title' => $title));
		}
	}
	
	/**
	 * @Route("/ryerson", name="rayku_ryerson_landing")
	 * @Template
	 */
	public function ryersonAction(){
		return $this->redirect('/ryerson/login');
	}
	
	/**
	 * @Route("/about", name="rayku_page_about")
	 * @Template
	 */
	public function aboutAction(){ }
		
	/**
	 * @Route("/legal", name="rayku_legal_page")
	 * @Template
	 */
	public function legalAction() { }

	/**
	 * @Route("/#/onboarding", name="rayku_page_tutor_onboard")
	 * @Template
	 */
	public function onboardAction(){
		$user = "user";
		return array($user=>$this->getUser());
	}
	
	/**
	 * @Route("/#/quiz", name="rayku_page_tutor_quiz")
	 * @Template
	 */
	public function quizAction(){
		$user = "user";
		return array($user=>$this->getUser());
	}

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
	 * @Route("/register/confirmed", name="rayku_register_confirmed")
	 * @Route("/dashboard", name="rayku_page_dashboard")
	 * @Route("/#/{username}", name="rayku_username_dashboard", options={"expose"=true})
	 * @Route("/ask", name="rayku_page_homepage_minimized_funnel")
	 * @Template
	 */
	public function indexAction($username = null)
	{
		if($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')){
			$user = $this->getUser();
			return $this->render(
				'RaykuPageBundle:Page:secure.html.twig',
				array(
					'user' => $user
				)
			);
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
	 * @Route("/session/{session}/rate", name="rayku_session_rate")
	 * @Template("RaykuPageBundle:Page:dashboard.html.twig")
	 * @param \Rayku\ApiBundle\Entity\Session $session
	 */
	public function rateSessionAction(Session $session)
	{
		$return = $this->dashboardAction();
		
		if(
				null === $session->getRating() &&
				$session->getStudent() == $this->getUser() &&
				null !== $session->getSelectedTutor())
		{
			if(null === $session->getEndTime()){
				$session->endNow();
				$em->persist($session);
				$em->persist($session->getStudent());
				if(null !== $session->getSelectedTutor()) $em->persist($session->getSelectedTutor());
				$em->flush();
			}
			$sessionRateForm = $this->createForm(new RateSessionType(), $session);
			$return['ratesessionform'] = $sessionRateForm->createView();
		}
		return $return;
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
	 * @Route("/course/{slug}/view", name="rayku_course_show")
	 * @Template()
	 */
	public function showCourseAction($slug)
	{
		$em = $this->getDoctrine()->getManager();
		$course = $em->getRepository('RaykuApiBundle:Course')->findOneBySlug($slug);
		if(!$course){
			return $this->redirect($this->generateUrl('rayku_page_dashboard'));
		}
		return array(
			'course' => $course,
			'user' => $this->getUser()
		);
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
