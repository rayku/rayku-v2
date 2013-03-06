<?php

namespace Rayku\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RegisterController extends Controller
{
    /**
     * @Route("/register", name="_rayku_register")
     * @Template()
     */
    public function indexAction($name = "Registered")
    {
        return array('name' => $name);
    }

    private function registrationAction(Request $request)
    {
    	return true;
    }
}
