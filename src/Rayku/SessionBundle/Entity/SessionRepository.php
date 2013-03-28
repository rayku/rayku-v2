<?php

namespace Rayku\SessionBundle\Entity;

use Doctrine\ORM\EntityRepository;

class SessionRepository extends EntityRepository
{
	public function findAllActiveByTutor($tutor_id)
	{
		$qb = $this->createQueryBuilder('s');
		$query = $qb
			->select(array('s'))
			->from('\Rayku\SessionBundle\Entity\Session', 'session')
			->innerJoin('session.potential_tutors', 't')
			->where('t.id = :tutorId')
			->andWhere('session.selected_tutor is NULL')
			->setParameter('tutorId', $tutor_id)
			->getQuery();
		
		try{
			return $query->getResult();
		} catch (\Doctrine\ORM\NoResultException $e) {
			return NULL;
		}
	}
}