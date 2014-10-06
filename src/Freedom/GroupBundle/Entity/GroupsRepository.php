<?php

namespace Freedom\GroupBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * GroupsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GroupsRepository extends EntityRepository
{

	//Init filters
	public function addFilters(QueryBuilder $qb, $filters)
	{
		foreach ($filters as $key => $value) {
			$qb->andWhere('p.'.$key.' IN (:'.$key.')')->setParameter($key, $value);
		}
		
	}

	public function apiSearch($name, $filters, $offset, $limit, $order_by)
	{

		//Get the order_by's key
		$keys = array_keys($order_by);

	  	$qb = $this->_em->createQueryBuilder();
	  	$qb->select('g')
	    ->from('FreedomGroupBundle:Groups', 'p')
	 	->where('p.name LIKE :name')            
        ->setParameter('name', '%'.$name.'%');
        $this->addFilters($qb, $filters);
        $qb->select('p')->orderBy('p.'.$keys[0], $order_by[$keys[0]])
        ->setFirstResult($offset)
        ->setMaxResults($limit);

	    $result = $qb->getQuery()->getResult();
	    return $result;

	}

	public function apiBelongSearch($user, $filters, $offset, $limit, $order_by)
	{
        
	  	$qb = $this->_em->createQueryBuilder();
		$qb->select('g')->from('FreedomGroupBundle:Groups', 'g')
		->leftJoin('g.userbelonggroups', 'gu')
	    ->where('gu.user = :user')
	    ->setParameter('user', $user);

	    $result = $qb->getQuery()->getResult();
	    return $result;

	}
	
}
