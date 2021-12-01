<?php

namespace App\Repository;

use App\Entity\AuctionHouse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AuctionHouse|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuctionHouse|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuctionHouse[]    findAll()
 * @method AuctionHouse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuctionHouseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuctionHouse::class);
    }

    // /**
    //  * @return AuctionHouse[] Returns an array of AuctionHouse objects
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
    public function findOneBySomeField($value): ?AuctionHouse
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
