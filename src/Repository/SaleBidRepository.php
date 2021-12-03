<?php

namespace App\Repository;

use App\Entity\SaleBid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SaleBid|null find($id, $lockMode = null, $lockVersion = null)
 * @method SaleBid|null findOneBy(array $criteria, array $orderBy = null)
 * @method SaleBid[]    findAll()
 * @method SaleBid[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaleBidRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SaleBid::class);
    }

    // /**
    //  * @return SaleBid[] Returns an array of SaleBid objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SaleBid
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
