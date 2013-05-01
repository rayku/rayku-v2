<?php

namespace Rayku\ApiBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TutorRepository extends EntityRepository
{
	public function findOnlineTutors($expire_online)
	{
		/**
		 * WHERE ((r0_.online_web > ? OR r0_.online_gtalk > ?) AND (r0_.busy < ? OR r0_.busy IS NULL)) AND (r0_.deletedAt IS NULL)
		 */
		$qb = $this->createQueryBuilder('t');
		$query = $qb
			->select('t', 'u')
			->join('t.user', 'u')
			->where($qb->expr()->orx(
				$qb->expr()->gt('t.onlineWeb', ':expire_online'),
				$qb->expr()->gt('t.onlineGtalk', ':expire_online')
			))
			->andWhere($qb->expr()->orx(
				$qb->expr()->lt('t.busy', ':expire_online'),
				't.busy IS NULL'
			))
			->setParameter('expire_online', date("Y-m-d H:i:s", strtotime($expire_online)))
			->getQuery();
		
		return $query->getResult();
	}
}