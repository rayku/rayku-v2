<?php

namespace Rayku\SessionBundle\Entity;

use Doctrine\ORM\EntityRepository;

class SessionRepository extends EntityRepository
{
	public function findAllActiveByTutor($tutor_id, $expire_session)
	{
		$qb = $this->createQueryBuilder('s');
		$query = $qb
			->select(array('s'))
			->from('\Rayku\SessionBundle\Entity\Session', 'session')
			->innerJoin('session.potential_tutors', 't')
			->where('t.tutor = :tutorId')
			->andWhere('t.tutorReply = \'pending\'')
			->andWhere('session.selected_tutor is NULL')
			->andWhere('session.endTime is NULL')
			->andWhere('s.createdAt > :expire_session')
			->setParameter('tutorId', $tutor_id)
			->setParameter('expire_session', date('Y-m-d H:i:s', strtotime($expire_session)))
			->getQuery();
		
		return $query->getResult();
		
		
		try{
			return $query->getResult();
		} catch (\Doctrine\ORM\NoResultException $e) {
			return NULL;
		}
	}
}