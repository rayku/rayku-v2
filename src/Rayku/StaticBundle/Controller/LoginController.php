<?php

namespace Rayku\StaticBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController extends Controller
{
    /**
     * @Route("/login_check", name="_rayku_user_login")
     * @Template()
     */
    public function loginCheckAction()
    {
        $response = new RedirectResponse('/dashboard');
        return $response;
    }
    /**
     * @Route("/logout", name="_rayku_user_logout")
     * @Template()
     */
    public function logoutAction()
    {
    	$response = new RedirectResponse('/');
        return $response;
    }
}
