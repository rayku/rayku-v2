<?php

namespace Rayku\UserBundle\EventListener;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Rayku\UserBundle\Entity\User;

class Activity
{
	protected $context;
	protected $em;
	
	public function __construct(SecurityContext $context, $doctrine)
	{
		$this->context = $context;
		$this->em = $doctrine->getEntityManager();
	}
	
	/**
	 * On each request we want to update the user's last activity datetime
	 *
	 * @param \Symfony\Component\HttpKernel\Event\FilterControllerEvent $event
	 * @return void
	 */
	public function onCoreController(FilterControllerEvent $event)
	{
		$user = NULL;
		if($this->context->getToken())
		{
			$user = $this->context->getToken()->getUser();
		}
		$user = $this->context->getToken()->getUser();
		if($user instanceof User)
		{
			//here we can update the user as necessary
			$user->setOnlineWeb(new \DateTime());
			$this->em->persist($user);
			$this->em->flush($user);
		}
	}
}
