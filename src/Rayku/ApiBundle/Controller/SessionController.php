<?php

namespace Rayku\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Rayku\ApiBundle\Entity\Session;
use Rayku\ApiBundle\Entity\SessionTutors;
use Rayku\ApiBundle\Form\SessionType;
use Rayku\ApiBundle\Form\RateSessionType;

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
		$sessions = $em->getRepository('RaykuApiBundle:Session')->findAllActiveByTutor($this->getUser()->getTutor()->getId(), Session::expire_session);
		
		return $sessions;
	}
	
	/**
	 * @ApiDoc(
	 *   description="Get a whiteboard session",
	 *   statusCodes={
	 *     200="Returned when successful"
	 *   }
	 * )
	 * @param \Rayku\ApiBundle\Entity\Session $session
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
	 * @param \Rayku\ApiBundle\Entity\Session $session
	 */
	public function postSessionDenyAction(Session $session)
	{
		$potentialTutor = $this->validateTutorRequested($session);
		
		if (!$potentialTutor) {
			throw $this->createNotFoundException('Unable to find Session.');
		}else{
			$potentialTutor->setTutorReply('rejected');
			$potentialTutor->getTutor()->setBusy(false);
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
	 * @param \Rayku\ApiBundle\Entity\Session $session
	 */
	public function getSessionAcceptAction(Session $session)
	{
		$session = $this->postSessionAcceptAction($session);
		if($session['success']){
			return $this->redirect($session['redirect']);
		}else{
			die($session['message']);
		}
	}
	
	/**
	 * @ApiDoc(
	 *   description="Accepts a whiteboard session for a tutor"
	 * )
	 * 
	 * @param \Rayku\ApiBundle\Entity\Session $session
	 */
	public function postSessionAcceptAction(Session $session)
	{
		$em = $this->getDoctrine()->getManager();
		$potentialTutor = $this->validateTutorRequested($session);
		
		if (!$potentialTutor) {
			throw $this->createNotFoundException('Unable to find Session.');
		}else{
			$potentialTutor->setTutorReply('replied');
			$potentialTutor->getTutor()->setBusy(true);
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
		$session->setUsersBusy();
		
		$em->persist($potentialTutor);
		$em->persist($session->getStudent());
		$em->persist($session);
		$em->flush();
		
		return array(
			'success' => true,
			'redirect' => $this->container->getParameter('whiteboard_url').'/room/'.$session->getId().'/tutor'
		);
	}
	
	/**
	 * @ApiDoc(
	 *   description="Starts a whiteboard session",
	 *   statusCodes={
	 *     200="Returned when successful"
	 *   }
	 * )
	 * @param \Rayku\ApiBundle\Entity\Session $session
	 */
	public function postSessionStartAction(Session $session)
	{
		$startTime = $session->getStartTime();
		if(isset($startTime)){
			return $session;
		}
		
		$currentDate = new \DateTime(date('Y-m-d H:i:s'));
		$session->setStartTime($currentDate);
		$session->setUsersBusy();
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($session);
		$em->persist($session->getStudent());
		$em->persist($session->getSelectedTutor());
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
	 * @todo emit and catch a end session event
	 * @param \Rayku\ApiBundle\Entity\Session $session
	 */
	public function postSessionEndAction(Session $session)
	{
		$session->endNow();
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($session);
		$em->flush();
			
		return $session;
	}

	/**
	 * @View
	 * @ApiDoc(
	 *   description="Rate a session",
	 *   input="Rayku\ApiBundle\Form\RateSession"
	 * )
	 * @param \Rayku\ApiBundle\Entity\Session $session
	 */
	public function postSessionRateAction(Session $session)
	{
		if($session->getStudent() !== $this->getUser()){
			throw new AccessDeniedException();
		}
		
		$session = $this->postSessionEndAction($session);
		$form = $this->createForm(new RateSessionType(), $session)->bind($this->getRequest());
	
		if($form->isValid()){
			$em = $this->getDoctrine()->getManager();
			$em->persist($session);
			$em->flush();
			return $session;
		}
		return $form;
	}
	
	/**
	 * @View()
	 * @ApiDoc(
	 *   resource=true,
	 *   description="Create a new session object",
	 *   input="Rayku\ApiBundle\Form\SessionType"
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
			return $this->redirect($this->container->getParameter('whiteboard_url').'/room/'.$session->getId().'/student');
		}
		return $form;
	}
}

