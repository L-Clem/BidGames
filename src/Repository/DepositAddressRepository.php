<?php

namespace App\Repository;

use App\Entity\DepositAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DepositAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method DepositAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method DepositAddress[]    findAll()
 * @method DepositAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepositAddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DepositAddress::class);
    }

    // /**
    //  * @return DepositAddress[] Returns an array of DepositAddress objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DepositAddress
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
