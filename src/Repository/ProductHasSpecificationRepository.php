<?php

namespace App\Repository;

use App\Entity\ProductHasSpecification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductHasSpecification|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductHasSpecification|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductHasSpecification[]    findAll()
 * @method ProductHasSpecification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductHasSpecificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductHasSpecification::class);
    }

    // /**
    //  * @return ProductHasSpecification[] Returns an array of ProductHasSpecification objects
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
    public function findOneBySomeField($value): ?ProductHasSpecification
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
