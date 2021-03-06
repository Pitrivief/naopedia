<?php

namespace App\Repository;

use App\Entity\Observation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ObservationRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Observation::class);
    }

    public function findByFilter($filters, $all = false) {

        $qb = $this->createQueryBuilder('o');
        if (key_exists("bird", $filters)) {
            $qb->andWhere('o.bird = :bird')
                    ->setParameter('bird', $filters["bird"]);
        }
        if (key_exists("dates", $filters)) {
            $qb->andWhere('o.searchDate IN (:dates)')
                    ->setParameter('dates', $filters["dates"], \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
        }  
        if (key_exists("user", $filters)) {
            $qb->andWhere('o.user = :user')
                    ->setParameter('user', $filters["user"]);
        }
        if (!$all) {
            $qb->andWhere('o.valid = :valid')
                    ->setParameter('valid', true);
        }
 
        
        
        return $qb->orderBy('o.date', 'ASC')
                        ->getQuery()
                        ->getResult();
        ;
    }

    /*
      public function findBySomething($value)
      {
      return $this->createQueryBuilder('o')
      ->where('o.something = :value')->setParameter('value', $value)
      ->orderBy('o.id', 'ASC')
      ->setMaxResults(10)
      ->getQuery()
      ->getResult()
      ;
      }
     */
}
