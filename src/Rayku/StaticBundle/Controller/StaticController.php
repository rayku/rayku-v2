<?php

namespace Rayku\StaticBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

// Login & Registration form
use Rayku\StaticBundle\Form\Type\UserType;
use Rayku\StaticBundle\Form\Type\TutorRegistrationType;

class StaticController extends Controller
{	
    private function form()
    {
        $form = $this->createForm(
            new UserType()
        );
        return $form;
    }

    /**
     * @Route("/home", name="homepage")
     */
    public function homepageAction()
    {
        die('not made yet');
    }

    /**
     * @Route("/", name="_welcome")
     */
    public function indexAction()
    {
        return $this->render('RaykuStaticBundle:Welcome:index.html.twig', array('form' => $this->form()->createView()));
    }
    
    /**
     * @Route("/login", name="_login")
     */
    public function loginAction()
    {
        $form  = $this->form();
        return $this->render('RaykuStaticBundle:Welcome:login.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/become-a-tutor", name="_become")
     */
    public function becomeAction()
    {
        return $this->render('RaykuStaticBundle:Welcome:become.html.twig', array('form' => $this->form()->createView()));
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
     * @Route("/signup", name="_signup")
     */
    public function signupAction()
    {
        $form = $this->createForm(
            new TutorRegistrationType()
        );
        return $this->render('RaykuStaticBundle:Welcome:signup.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * @Route("/about", name="_about")
     */
    public function aboutAction()
    {
        return $this->render('RaykuStaticBundle:Welcome:about.html.twig', array('form' => $this->form()->createView()));
    }
}