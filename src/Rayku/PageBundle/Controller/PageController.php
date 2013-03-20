<?php

namespace Rayku\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Page controller.
 *
 * @Route("/")
 */
class PageController extends Controller
{
	/**
	 * @Route("/dashboard", name="rayku_page_dashboard")
	 */
	public function dashboardAction()
	{
		return $this->render('RaykuPageBundle:Page:dashboard.html.twig');
	}

	/**
	 * @Route("/", name="rayku_page_homepage")
	 */
	public function indexAction()
	{
		return $this->render('RaykuPageBundle:Page:home.html.twig');
	}
	
	/**
	 * @Route("/about", name="rayku_page_about")
	 */
	public function aboutAction()
	{
		return $this->render('RaykuPageBundle:Page:about.html.twig');
	}
	
	/**
	 * @Route("/become-a-tutor", name="rayku_page_become_a_tutor")
	 */
	public function becomeTutorAction()
	{
		return $this->render('RaykuPageBundle:Page:become.html.twig');
	}
}
