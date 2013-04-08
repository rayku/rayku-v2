<?php

namespace Rayku\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Rayku\UserBundle\Form\UserType;
use Rayku\SessionBundle\Form\RateSessionType;
use Rayku\SessionBundle\Entity\Session;

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
		$userEditForm = $this->createForm(new UserType(), $this->getUser());
		
		$view['userform'] = $userEditForm->createView();
		
		if(isset($id)){
			$em = $this->getDoctrine()->getManager();
			$session = $em->getRepository('RaykuSessionBundle:Session')->find($id);
			if(null === $session->getRating()){
				$sessionRateForm = $this->createForm(new RateSessionType(), $session);
				$view['session'] = $session;
				$view['ratesessionform'] = $sessionRateForm->createView();
			}
		}
		
		return $this->render('RaykuPageBundle:Page:dashboard.html.twig', $view);
	}	
}
