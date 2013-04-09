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
use Rayku\SessionBundle\Form\RateSessionType;

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
		if(!$this->getUser() || !$this->getUser()->getIsTutor()){
			return array();
		}
		$em = $this->getDoctrine()->getManager();
		$sessions = $em->getRepository('RaykuSessionBundle:Session')->findAllActiveByTutor($this->getUser()->getTutor()->getId(), Session::expire_session);
		
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
	 *   description="Deny a whiteboard session request"
	 * )
	 * 
	 * @param \Rayku\SessionBundle\Entity\Session $session
	 */
	public function postSessionDenyAction(Session $session)
	{
		$potentialTutor = $this->validateTutorRequested($session);
		
		if (!$potentialTutor) {
			throw $this->createNotFoundException('Unable to find Session.');
		}else{
			$potentialTutor->setTutorReply('rejected');
			$em = $this->getDoctrine()->getManager();
			$em->persist($potentialTutor);
			$em->flush();
		}
		
		return array('success' => true);
	}
	
	private function validateTutorRequested(Session $session)
	{
		$em = $this->getDoctrine()->getManager();
		$currentTutor = $this->getUser()->getTutor();
		
		// Make sure I'm one of the tutors requested for this session
		foreach($session->getPotentialTutors() as $potentialTutor)
		{
			if($potentialTutor->getTutor() == $currentTutor)
			{
				return $potentialTutor;
			}
		}
		return false;
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
		$em = $this->getDoctrine()->getManager();
		$potentialTutor = $this->validateTutorRequested($session);
		
		if (!$potentialTutor) {
			throw $this->createNotFoundException('Unable to find Session.');
		}else{
			$potentialTutor->setTutorReply('replied');
			$em->persist($potentialTutor);
		}
		
		// Make sure no one else has beat me to this session
		$selectedTutor = $session->getSelectedTutor();
		if (!empty($selectedTutor)){
			$potentialTutor->setTutorReply('missed');
			$em->persist($potentialTutor);
			$em->flush();
			
			return array(
				'success' => false, 
				'message' => 'Someone else accepted this request'
			);
		}
		
		$session->setSelectedTutor($potentialTutor->getTutor());
		$session->setRate($potentialTutor->getRate());
		$potentialTutor->setTutorReply('accepted');
		
		$em->persist($potentialTutor);
		$em->persist($session);
		$em->flush();
		
		return array(
			'success' => true,
			'redirect' => 'http://whiteboard.rayku.com/room/'.$session->getId().'/tutor'
		);
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
		
		// @todo should this move to the model or a event?
		$minutes = $duration->days * 24 * 60;
		$minutes += $duration->h * 60;
		$minutes += $duration->i;
		
		$session->setDuration($minutes);
		$session->setEndTime($currentDate);
		$points = $minutes * $session->getRate();
		$tutor = $session->getSelectedTutor()->getUser()->addPoints($points);
		$student = $session->getStudent()->subtractPoints($points);
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($session);
		$em->persist($tutor);
		$em->persist($student);
		$em->flush();
			
		return $session;
	}

	/**
	 * @View
	 * @ApiDoc(
	 *   description="Rate a session",
	 *   input="Rayku\SessionBundle\Form\RateSession"
	 * )
	 * @param \Rayku\SessionBundle\Entity\Session $session
	 */
	public function postSessionRateAction(Session $session)
	{
		$form = $this->createForm(new RateSessionType(), $session)->bind($this->getRequest());
	
		if($form->isValid()){
			$em = $this->getDoctrine()->getManager();
			$em->persist($session);
			// @todo shouldn't be necessary
			foreach($session->getPotentialTutors() as $potentialTutor){
				$potentialTutor->setSession($session);
				$em->persist($potentialTutor);
			}
			$em->flush();
			// @todo put this url in a config somewhere
			return $session;
		}
		return $form;
	}
	
	/**
	 * @View()
	 * @ApiDoc(
	 *   resource=true,
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
			// @todo shouldn't be necessary
			foreach($session->getPotentialTutors() as $potentialTutor){
				$potentialTutor->setSession($session);
				$em->persist($potentialTutor);
			}
			$em->flush();
			// @todo put this url in a config somewhere
			return $this->redirect('http://whiteboard.rayku.com/room/'.$session->getId().'/student');
		}
		return $form;
	}
}

