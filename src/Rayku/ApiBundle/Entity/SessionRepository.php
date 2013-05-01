<?php

namespace Rayku\ApiBundle\Entity;

use Doctrine\ORM\EntityRepository;

class SessionRepository extends EntityRepository
{
	public function findAllActiveByTutor($tutor_id, $expire_session)
	{
		$qb = $this->createQueryBuilder('s');
		$query = $qb
			->select('s')
			->innerJoin('s.potential_tutors', 't')
			->where('t.tutor = :tutorId')
			->andWhere('t.tutorReply = \'pending\'')
			->andWhere('s.selected_tutor is NULL')
			->andWhere('s.endTime is NULL')
			->andWhere('s.createdAt > :expire_session')
			->setParameter('tutorId', $tutor_id)
			->setParameter('expire_session', date('Y-m-d H:i:s', strtotime($expire_session)))
			->getQuery();		
		
		try{
			return $query->getResult();
		} catch (\Doctrine\ORM\NoResultException $e) {
			return NULL;
		}
	}
}