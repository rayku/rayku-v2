<?php

namespace Rayku\StaticBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

// login form
use Rayku\StaticBundle\Form\LoginType;

class WelcomeController extends Controller
{	
	/**
     * @Route("/", name="_welcome")
     */
    public function indexAction()
    {
        /*
         * The action's view can be rendered using render() method
         * or @Template annotation as demonstrated in DemoController.
         *
         */

        $registration = array();
        $form = $this->createForm(new LoginType(), $registration);
        array('form' => $form->createView());
        return $this->render('RaykuStaticBundle:Welcome:index.html.twig', array('form' => $form->createView()));
    }
    /**
     * @Route("/login", name="_rayku_login")
     * @Template()
     */
    public function loginAction()
    {
        /*
         * Renders the login page
         *
         */
        return $this->render('RaykuStaticBundle:Login:index.html.twig');
    }
    /**
     * @Route("/register", name="_rayku_register")
     * @Template()
     */
    public function RegisterAction(Request $request)
    {
        /*
         * Renders the registration page
         *
         */
        
        return $this->render('RaykuStaticBundle:Register:index.html.twig');
    }
}