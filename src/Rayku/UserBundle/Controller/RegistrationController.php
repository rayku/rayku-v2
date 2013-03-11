<?php

namespace Rayku\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

//Sessions
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="_rayku_user_register")
     * 
     */
    public function registerAction(Request $request)
    {
        $name = 'Samuel';
        $session = new Session();
        $session_id = $session->getId();

        if($session_id == ""){
            $response = new RedirectResponse('/');
        }

        $response = new RedirectResponse('/dashboard');
        return $response;
    }
    
    private function registrationAction(Request $request)
    {
    	return true;
    }
}
?>
