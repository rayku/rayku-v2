<?php

namespace Rayku\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="_rayku_login")
     * @Template()
     */
    public function indexAction($name = "Logged In")
    {
        return array('name' => $name);
    }
}
