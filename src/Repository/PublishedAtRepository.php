<?php

namespace App\Repository;

use App\Entity\PublishedAt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PublishedAt|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublishedAt|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublishedAt[]    findAll()
 * @method PublishedAt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublishedAtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PublishedAt::class);
    }

    // /**
    //  * @return PublishedAt[] Returns an array of PublishedAt objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PublishedAt
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
