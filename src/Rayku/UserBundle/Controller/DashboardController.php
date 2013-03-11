<?php

namespace Rayku\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DashboardController extends Controller
{
    /**
     * @Route("/dashboard", name="_rayku_user_dashboard")
     * @Template()
     */
    public function indexAction($name = "On Dashboard")
    {
        return array('name' => $name);
    }
}
