<?php

namespace Freedom\ObjectiveBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * ObjectiveRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ObjectiveRepository extends EntityRepository
{

	// public function myFindOne($id)
	// {
	//   	$qb = $this->_em->createQueryBuilder();
	//   	$qb->select('o')
	//      ->from('FreedomObjectiveBundle:Objective', 'o')
	//      ->leftJoin('o.steps', 's')
 //         ->addSelect('s')
	//      ->leftJoin('o.user', 'u')
 //         ->addSelect('u')
	//      ->where('o.id = :id')
	//      ->setParameter('id', $id);
	    
	//     $objectiveArray = $qb->getQuery()->getArrayResult()[0];

	//     //Get the number of days left
	//     $objectiveObject = $qb->getQuery()->getOneOrNullResult();
	//     $objectiveArray['numberOfDays'] = $objectiveObject->getNumberOfDays();

	//     //Get advices with user joined
	//   	$qb2 = $this->_em->createQueryBuilder();
	//   	$qb2->select('a')
	//      ->from('FreedomObjectiveBundle:Advice', 'a')
	//      ->leftJoin('a.user', 'u')
 //         ->addSelect('u')
	//      ->where('a.objective = :id')
	//      ->setParameter('id', $id);

	//     $objectiveArray['advices'] = !empty($qb2->getQuery()->getArrayResult()) ? $qb2->getQuery()->getArrayResult() : [];

	//     return $objectiveArray;
	// }

	//Init filters
	public function addFilters(QueryBuilder $qb, $filters)
	{
		foreach ($filters as $key => $value) {
			$qb->andWhere('o.'.$key.' IN (:'.$key.')')->setParameter($key, $value);
		}
		
	}

	public function apiSearch($name, $filters, $offset, $limit, $order_by)
	{

		//Get the order_by's key
		$keys = array_keys($order_by);

	  	$qb = $this->_em->createQueryBuilder();
	  	$qb->select('o')
	    ->from('FreedomObjectiveBundle:Objective', 'o')
	 	->where('o.name LIKE :name')            
        ->setParameter('name', '%'.$name.'%');
        $this->addFilters($qb, $filters);
        $qb->select('o')->orderBy('o.'.$keys[0], $order_by[$keys[0]])
        ->setFirstResult($offset)
        ->setMaxResults($limit);

	    $result = $qb->getQuery()->getResult();
	    return $result;

	}

}
