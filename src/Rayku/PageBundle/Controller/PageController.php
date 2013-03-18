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
	 * @Route("/", name="homepage")
	 */
	public function indexAction()
	{
		return $this->render('RaykuPageBundle:Page:home.html.twig');
	}
}
