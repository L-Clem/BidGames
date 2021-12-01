<?php

namespace App\Repository;

use App\Entity\AnnounceBid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AnnounceBid|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnnounceBid|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnnounceBid[]    findAll()
 * @method AnnounceBid[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnounceBidRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnnounceBid::class);
    }

    // /**
    //  * @return AnnounceBid[] Returns an array of AnnounceBid objects
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
    public function findOneBySomeField($value): ?AnnounceBid
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
