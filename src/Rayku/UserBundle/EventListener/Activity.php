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
		$this->em->getFilters()->enable('soft_deleteable');
		$this->em->clear();
		$user = NULL;
		if($this->context->getToken())
		{
			$user = $this->context->getToken()->getUser();
		}
		if($user instanceof User && $user->getIsTutor() && null === $user->getTutor()->getDeletedAt())
		{
			$tutor = $user->getTutor();
			$tutor->setOnlineWeb(new \DateTime());
			$this->em->persist($tutor);
			$this->em->flush($tutor);
		}
	}
}
