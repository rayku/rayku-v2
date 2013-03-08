<?php

namespace Rayku\StaticBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

// Login & Registration form
use Rayku\StaticBundle\Form\Type\UserType;
use Rayku\StaticBundle\Form\Type\TutorRegistrationType;
//use Rayku\StaticBundle\Form\Model\Registration;

class WelcomeController extends Controller
{	
	/**
     * @Route("/", name="_welcome")
     */
    private function form()
    {
        $form = $this->createForm(
            new UserType()
        );
        return $form;
    }
    public function indexAction()
    {
        /*
         * The action's view can be rendered using render() method
         * or @Template annotation as demonstrated in DemoController.
         *
         */
        $form  = $this->form();
        return $this->render('RaykuStaticBundle:Welcome:index.html.twig', array('form' => $form->createView()));
    }
    public function createAction()
    {

    }
    /**
     * @Route("/become-a-tutor", name="_become")
     */
    public function becomeAction()
    {
        $form  = $this->form();
        return $this->render('RaykuStaticBundle:Welcome:become.html.twig', array('form' => $form->createView()));
    }
    /**
     * @Route("/signup-tutor", name="_signup_tutor")
     */
    public function signupTutorAction()
    {
        $form = $this->createForm(
            new TutorRegistrationType()
        );
        return $this->render('RaykuStaticBundle:Welcome:signup-tutor.html.twig', array('form' => $form->createView()));
    }
    /**
     * @Route("/about", name="_become")
     */
    public function aboutAction()
    {
        $form  = $this->form();
        return $this->render('RaykuStaticBundle:Welcome:about.html.twig', array('form' => $form->createView()));
    }
}