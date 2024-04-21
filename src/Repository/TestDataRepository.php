<?php

namespace App\Repository;

use App\Entity\TestData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TestData>
 *
 * @method TestData|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestData|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestData[]    findAll()
 * @method TestData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestData::class);
    }

//    /**
//     * @return TestData[] Returns an array of TestData objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TestData
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
