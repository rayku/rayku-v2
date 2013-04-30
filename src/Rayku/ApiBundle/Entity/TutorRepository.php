<?php

namespace Rayku\ApiBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TutorRepository extends EntityRepository
{
	public function findOnlineTutors($expire_online)
	{
		$query = $this->createQueryBuilder('t')
			->where('t.onlineWeb > :expire_online')
			->andWhere('t.busy < :expire_online')
			->join('t.user', 'u')
			->orWhere('t.onlineGtalk > :expire_online')
			->setParameter('expire_online', date("Y-m-d H:i:s", strtotime($expire_online)))
			->getQuery();
		
		return $query->getResult();
	}
}