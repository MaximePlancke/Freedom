<?php

namespace Freedom\ObjectiveBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AdviceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdviceRepository extends EntityRepository
{
	public function myFindOne($id) {

		$qb2 = $this->_em->createQueryBuilder();
	  	$qb2->select('a')
	     ->from('FreedomObjectiveBundle:Advice', 'a')
	     ->leftJoin('a.user', 'u')
         ->addSelect('u')
	     ->where('a.id = :id')
	     ->setParameter('id', $id);

	    $advice = $qb2->getQuery()->getArrayResult()[0];
	    return $advice;
	} 
}
