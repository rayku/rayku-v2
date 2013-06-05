<?php

namespace Rayku\UserBundle\EventListener;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\HttpKernel;
use Rayku\UserBundle\Entity\User;

class Activity
{
	protected $context;
	protected $em;
	
	public function __construct(SecurityContext $context, $doctrine)
	{
		$this->context = $context;
		$this->em = $doctrine->getManager();
	}
	
	/**
	 * On each request we want to update the user's last activity datetime
	 *
	 * @param \Symfony\Component\HttpKernel\Event\FilterControllerEvent $event
	 * @return void
	 */
	public function onCoreController(FilterControllerEvent $event)
	{
		if(HttpKernel::MASTER_REQUEST != $event->getRequestType()){
			return true;
		}
		if(!$event->getRequest()->isMethod('GET') || HttpKernelInterface::MASTER_REQUEST != $event->getRequestType()){
			return true;
		}
		$user = NULL;
		if($this->context->getToken())
		{
			$user = $this->context->getToken()->getUser();
		}
		if(method_exists($user, 'getIsTutor') && $user->getIsTutor() && null === $user->getTutor()->getDeletedAt())
		{
			$tutor = $this->em->getRepository('RaykuApiBundle:Tutor')->findOneByUser($user);
			$tutor->setOnlineWeb(new \DateTime());
			$this->em->persist($tutor);
			$this->em->flush($tutor);
		}
	}
}
