<?php

namespace App\Repository;

use App\Entity\CategoryReference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoryReference|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryReference|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryReference[]    findAll()
 * @method CategoryReference[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryReferenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryReference::class);
    }

    // /**
    //  * @return CategoryReference[] Returns an array of CategoryReference objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategoryReference
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
