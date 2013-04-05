<?php

namespace Rayku\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Rayku\UserBundle\Form\UserType;

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
	
	public function dashboardAction()
	{
		$userEditForm = $this->createForm(new UserType(), $this->getUser());
		
		return $this->render('RaykuPageBundle:Page:dashboard.html.twig', array(
			'userform' => $userEditForm->createView()
		));
	}
}
