<?php

namespace App\Repository;

use App\Entity\ActionHouse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ActionHouse|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActionHouse|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActionHouse[]    findAll()
 * @method ActionHouse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActionHouseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActionHouse::class);
    }

    // /**
    //  * @return ActionHouse[] Returns an array of ActionHouse objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ActionHouse
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
