<?php

namespace Rayku\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session as PHPSession;
use Rayku\ApiBundle\Form\UserType;
use Rayku\ApiBundle\Form\UserSettingType;
use Rayku\ApiBundle\Form\RateSessionType;
use Rayku\UserBundle\Form\Type\RegistrationAndProfileFormType;
use Rayku\ApiBundle\Entity\Session;
use Rayku\ApiBundle\Entity\User;
use Rayku\ApiBundle\Entity\Tutor;
use Rayku\ApiBundle\Entity\SessionTutors;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Page controller.
 *
 */
class PageController extends Controller
{
	public function indexAction()
	{
		if($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')){
			return $this->redirect($this->generateUrl('rayku_page_dashboard'));
		}
		return $this->render('RaykuPageBundle:Page:home.html.twig');
	}
	
	public function autoConnectSessionAction()
	{
		// @todo refactor to use REST api GET /tutors
		$em = $this->getDoctrine()->getManager();
		$tutors = $em->getRepository('RaykuApiBundle:Tutor')->findOnlineTutors(Tutor::expire_online, $this->getUser()->getId());
	
		if(empty($tutors)){
			return $this->forward('RaykuPageBundle:Page:dashboard');
		}
		// @todo refactor to use REST api POST /sessions
		$session = new Session();
		$session->setQuestion($this->getUser()->getSignupQuestion());
		$session->setStudent($this->getUser());
		foreach($tutors as $tutor){
			$potentialTutor = new SessionTutors();
			$potentialTutor->setTutor($tutor);
			$session->addPotentialTutor($potentialTutor);
		}
	
		$em->persist($session);
		$em->flush();
	
		return $this->redirect($this->container->getParameter('whiteboard_url').'/room/'.$session->getId().'/student');
	}
	
	public function dashboardAction($id = NULL)
	{
		//\Doctrine\Common\Util\Debug::dump($this->container->parameters);
		if($this->getRequest()->isMethod('POST') && null == $this->getUser()){
			$user = new User();
			$user->setSignupQuestion($this->getRequest()->get('question'));
			$user->setFirstName('');
			$view['user'] = $user;
			$view['registrationform'] = $this->createForm(new RegistrationAndProfileFormType(get_class($user)), $user)->createView();
		}else if(false === $this->get('security.context')->isGranted('ROLE_USER')){
			throw new AccessDeniedException();
		}else{
			$view['user'] = $this->getUser();
		}
		
		$userEditForm = $this->createForm(new UserType(), $this->getUser());
		$view['userform'] = $userEditForm->createView();
		
		$userSettingForm = $this->createForm(new UserSettingType(), $this->getUser());
		$view['usersettingform'] = $userSettingForm->createView();
		
		/*
		 * @todo move logic to the model layer
		 * @todo proper error messages to the user
		 * @todo allow tutors to rate the session
		 * @todo move to repository class out of controller
		 */
		if(isset($id)){
			$em = $this->getDoctrine()->getManager();
			$session = $em->getRepository('RaykuApiBundle:Session')->find($id);
			if(
				null === $session->getRating() && 
				$session->getStudent() == $this->getUser())
			{
				if(null === $session->getEndTime()){
					$session->endNow();
					$em->persist($session);
					$em->persist($session->getStudent());
					if(null !== $session->getSelectedTutor()) $em->persist($session->getSelectedTutor());
					$em->flush();
				}
				$sessionRateForm = $this->createForm(new RateSessionType(), $session);
				$view['session'] = $session;
				$view['ratesessionform'] = $sessionRateForm->createView();
			}
		}
		
		return $this->render('RaykuPageBundle:Page:dashboard.html.twig', $view);
	}
}
