<?php

namespace Freedom\UserBundle\Entity;

use Freedom\ObjectiveBundle\Entity\Objective;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * UserfollowobjectiveRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserfollowobjectiveRepository extends EntityRepository
{

	//Init filters
	// public function addFilters(QueryBuilder $qb, $filters)
	// {
	// 	foreach ($filters as $key => $value) {
	// 		$qb->andWhere('o.'.$key.' IN (:'.$key.')')->setParameter($key, $value);
	// 	}
		
	// }

	// public function apiSearch($user, $filters, $offset, $limit, $order_by)
	// {

	// 	//Get the order_by's key
	// 	$keys = array_keys($order_by);

	//   	$qb = $this->_em->createQueryBuilder();
	//   	$qb->select('u')
	//     ->from('FreedomUserBundle:Userfollowobjective', 'u')
	// 	// ->join('u.objective', 'o')
	//     ->where('u.user = :user')
	//     ->setParameter('user', $user);
 //        $this->addFilters($qb, $filters);
 //        $qb->select('u')->orderBy('u.'.$keys[0], $order_by[$keys[0]])
 //        ->setFirstResult($offset)
 //        ->setMaxResults($limit);

	//     $result = $qb->getQuery()->getResult();
	//     return $result;

	// }


}
