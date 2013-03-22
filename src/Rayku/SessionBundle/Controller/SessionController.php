<?php

namespace Rayku\SessionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
#use FOS\RestBundle\Controller\FOSRestController as Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Rayku\SessionBundle\Entity\Session;
use Rayku\SessionBundle\Form\SessionType;

/**
 * Session controller.
 */
class SessionController extends Controller
{
	
	/**
	 * @Route("/session/{session}/keepalive.{_format}", requirements={"session" = "\d+"}, defaults={"_format" = "json"})
	 * @Method({"POST"})
	 * @ApiDoc(
	 *   description="Ends a whiteboard session",
	 *   statusCodes={
	 *     200="Returned when successful"
	 *   }
	 * )
	 * @param \Rayku\SessionBundle\Entity\Session $session
	 */
	public function postSessionEndAction(Session $session)
	{
		if(isset($session->getEndTime())){
			return $session;
		}
		
		$currentDate = new \DateTime(date('Y-m-d H:i:s'));
		$duration = $currentDate->diff($session->getStartTime());
		
		$session->setDuration($duration->days * 24 * 60);
		$session->setEndTime($currentDate);
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($session);
		$em->flush();
			
		return $session;
	}
	
	/**
	 * @View()
	 * @ApiDoc(
	 *   description="Create a new session object",
	 *   input="Rayku\SessionBundle\Form\SessionType"
	 * )
	 */
	public function postSessionAction()
	{
		return $this->processForm(new Session());
	}
	
	private function processForm(Session $session)
	{
		$form = $this->createForm(new SessionType(), $session)->bind($this->getRequest());
		
		if($form->isValid()){
			$em = $this->getDoctrine()->getManager();
			$em->persist($session);
			$em->flush();
			
			return $session;
		}
		
		return $form;
	}
}

