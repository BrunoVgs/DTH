<?php

namespace App\Repository;

use App\Entity\CollectionCenter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CollectionCenter>
 *
 * @method CollectionCenter|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollectionCenter|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollectionCenter[]    findAll()
 * @method CollectionCenter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollectionCenterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CollectionCenter::class);
    }

//    /**
//     * @return CollectionCenter[] Returns an array of CollectionCenter objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CollectionCenter
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
