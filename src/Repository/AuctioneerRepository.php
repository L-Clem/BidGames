<?php

namespace App\Repository;

use App\Entity\Auctioneer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Auctioneer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Auctioneer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Auctioneer[]    findAll()
 * @method Auctioneer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuctioneerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Auctioneer::class);
    }

    // /**
    //  * @return Auctioneer[] Returns an array of Auctioneer objects
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
    public function findOneBySomeField($value): ?Auctioneer
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
