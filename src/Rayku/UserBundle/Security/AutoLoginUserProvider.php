<?php

namespace Rayku\UserBundle\Security;

use Jmikola\AutoLogin\User\AutoLoginUserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AutoLoginUserProvider implements AutoLoginUserProviderInterface
{
	protected $em;
	
	public function __construct($doctrine)
	{
		$this->em = $doctrine->getManager();
	}
	
	public function loadUserByAutoLoginToken($key = false)
	{
		if(!$key){
			throw new AuthenticationException('Auto login authentication failed.');
		}
		
		$repository = $qb = $this->em->getRepository('RaykuApiBundle:User');
		$qb = $repository->createQueryBuilder('u');
		$query = $qb
			->select(array('u'))
			->from('\Rayku\ApiBundle\Entity\User', 'user')
			->where('u.autoLogin = :key')
			->andWhere('u.autoLoginExpire > :expire')
			->setParameter('key', $key)
			->setParameter('expire', date('Y-m-d H:i:s'))
			->getQuery();
		
		try{
			$user = $query->getSingleResult();
		} catch (\Doctrine\ORM\NoResultException $e) {
			throw new AuthenticationException('Auto login authentication failed.');
		}
		
		$user->clearAutoLogin();
		$this->em->persist($user);
		$this->em->flush();
		
		return $user;
	}
}