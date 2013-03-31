<?php

namespace Rayku\SessionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Rayku\SessionBundle\Entity\Session;
use Rayku\SessionBundle\Entity\SessionTutors;
use Rayku\SessionBundle\Form\SessionType;

/**
 * RestSession controller.
 */
class SessionController extends Controller
{
	/**
	 * @ApiDoc(
	 *   description="Get active sessions for a tutor",
	 *   statusCodes={
	 *     200="Returned when successful"
	 *   }
	 * )
	 */
	public function getSessionsAction()
	{
		$em = $this->getDoctrine()->getManager();
		$sessions = $em->getRepository('RaykuSessionBundle:Session')->findAllActiveByTutor($this->getUser()->getTutor()->getId());
		
		return $sessions;
	}
	
	/**
	 * @ApiDoc(
	 *   description="Get a whiteboard session",
	 *   statusCodes={
	 *     200="Returned when successful"
	 *   }
	 * )
	 * @param \Rayku\SessionBundle\Entity\Session $session
	 */
	public function getSessionAction(Session $session)
	{
		return $session;
	}
	
	/**
	 * @ApiDoc(
	 *   description="Accepts a whiteboard session for a tutor"
	 * )
	 * 
	 * @param \Rayku\SessionBundle\Entity\Session $session
	 */
	public function postSessionAcceptAction(Session $session)
	{
		$valid = false;
		$em = $this->getDoctrine()->getManager();
		$currentTutor = $this->getUser()->getTutor();
		
		// Make sure I'm one of the tutors requested for this session
		foreach($session->getPotentialTutors() as $potentialTutor)
		{
			if($potentialTutor->getTutor() == $currentTutor)
			{
				$valid = true;
				$potentialTutor->setTutorReply('replied');
				$em->persist($potentialTutor);				
			}
		}
		
		if (!$valid) {
			throw $this->createNotFoundException('Unable to find Session.');
		}
		
		// Make sure no one else has beat me to this session
		$selectedTutor = $session->getSelectedTutor();
		if (!empty($selectedTutor)){
			$potentialTutor->setTutorReply('missed');
			$em->persist($potentialTutor);
			$em->flush();
			
			return new Response(json_encode(array(
				'success' => false, 'message' => 'Someone else accepted this request'))
			);
		}
		
		$session->setSelectedTutor($currentTutor);
		$session->setRate($potentialTutor->getRate());
		$potentialTutor->setTutorReply('accepted');
		
		$em->persist($potentialTutor);
		$em->persist($session);
		$em->flush();
		
		return $session;
	}
	
	/**
	 * @ApiDoc(
	 *   description="Starts a whiteboard session",
	 *   statusCodes={
	 *     200="Returned when successful"
	 *   }
	 * )
	 * @param \Rayku\SessionBundle\Entity\Session $session
	 */
	public function postSessionStartAction(Session $session)
	{
		$startTime = $session->getStartTime();
		if(isset($startTime)){
			return $session;
		}
		
		$currentDate = new \DateTime(date('Y-m-d H:i:s'));
		$session->setStartTime($currentDate);
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($session);
		$em->flush();
		
		return $session;
	}
	
	/**
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
		$endTime = $session->getEndTime();
		if(isset($endTime)){
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
		$session->setStudent($this->getUser());
		$form = $this->createForm(new SessionType(), $session)->bind($this->getRequest());
		
		if($form->isValid()){
			$em = $this->getDoctrine()->getManager();
			$em->persist($session);
			$em->flush();
			// @todo put this url in a config somewhere
			return $this->redirect('http://whiteboard.rayku.com/room/'.$session->getId());
		}
		return $form;
	}
}

