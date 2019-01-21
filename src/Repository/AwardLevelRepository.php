<?php

namespace App\Repository;

use App\Entity\AwardLevel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AwardLevel|null find($id, $lockMode = null, $lockVersion = null)
 * @method AwardLevel|null findOneBy(array $criteria, array $orderBy = null)
 * @method AwardLevel[]    findAll()
 * @method AwardLevel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AwardLevelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AwardLevel::class);
    }

    // /**
    //  * @return AwardLevel[] Returns an array of AwardLevel objects
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
    public function findOneBySomeField($value): ?AwardLevel
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
