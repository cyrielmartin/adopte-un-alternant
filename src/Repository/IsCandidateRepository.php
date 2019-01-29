<?php

namespace App\Repository;

use App\Entity\IsCandidate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IsCandidate|null find($id, $lockMode = null, $lockVersion = null)
 * @method IsCandidate|null findOneBy(array $criteria, array $orderBy = null)
 * @method IsCandidate[]    findAll()
 * @method IsCandidate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IsCandidateRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IsCandidate::class);
    }

    

    // /**
    //  * @return IsCandidate[] Returns an array of IsCandidate objects
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
    public function findOneBySomeField($value): ?IsCandidate
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
