<?php

namespace Rayku\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Rayku\ApiBundle\Form\UserType;
use Rayku\ApiBundle\Form\UserSettingType;
use Rayku\ApiBundle\Form\RateSessionType;
use Rayku\ApiBundle\Entity\Session;
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
	
	public function dashboardAction($id = NULL)
	{
		if(false === $this->get('security.context')->isGranted('ROLE_USER')){
			throw new AccessDeniedException();
		}
		
		$userEditForm = $this->createForm(new UserType(), $this->getUser());
		$view['userform'] = $userEditForm->createView();
		
		$userSettingForm = $this->createForm(new UserSettingType(), $this->getUser());
		$view['usersettingform'] = $userSettingForm->createView();
		
		/*
		 * @todo move logic to the model layer
		 * @todo proper error messages to the user
		 * @todo allow tutors to rate the session
		 */
		if(isset($id)){
			$em = $this->getDoctrine()->getManager();
			$session = $em->getRepository('RaykuApiBundle:Session')->find($id);
			if(
				null === $session->getRating() && 
				$session->getStudent() == $this->getUser() &&
				null !== $session->getStartTime())
			{
				if(null === $session->getEndTime()){
					//@todo emit and catch a end session event
					$session->endNow();
					$em = $this->getDoctrine()->getManager();
					$em->persist($session);
					$em->persist($session->getStudent());
					$em->persist($session->getSelectedTutor());
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
