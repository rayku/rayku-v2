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
     * @Route("/", name="_welcome")
     */
    public function indexAction()
    {
        return $this->render('RaykuStaticBundle:Welcome:index.html.twig', array('form' => $this->form()->createView()));
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
     * @Route("/about", name="_become")
     */
    public function aboutAction()
    {
        return $this->render('RaykuStaticBundle:Welcome:about.html.twig', array('form' => $this->form()->createView()));
    }
}