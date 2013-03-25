<?php

namespace Rayku\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
