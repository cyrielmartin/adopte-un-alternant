<?php

namespace App\Repository;

use App\Entity\IsStory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IsStory|null find($id, $lockMode = null, $lockVersion = null)
 * @method IsStory|null findOneBy(array $criteria, array $orderBy = null)
 * @method IsStory[]    findAll()
 * @method IsStory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IsStoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IsStory::class);
    }

    // /**
    //  * @return IsStory[] Returns an array of IsStory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IsStory
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
