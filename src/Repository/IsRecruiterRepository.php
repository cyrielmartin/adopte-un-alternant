<?php

namespace App\Repository;

use App\Entity\IsRecruiter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IsRecruiter|null find($id, $lockMode = null, $lockVersion = null)
 * @method IsRecruiter|null findOneBy(array $criteria, array $orderBy = null)
 * @method IsRecruiter[]    findAll()
 * @method IsRecruiter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IsRecruiterRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IsRecruiter::class);
    }

    /**
     * @return Query
     */

    public function findViewProfil($candidateId)
    {
       $qb = $this
           ->createQueryBuilder('isRecruiter')
           ->join('isRecruiter.isCandidates', 'isCandidate')
           ->addSelect('isCandidate')
           ->where('isCandidate.id = :isCandidateId')
           ->setParameter('isCandidateId', $candidateId);
       ;

       return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return IsRecruiter[] Returns an array of IsRecruiter objects
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
    public function findOneBySomeField($value): ?IsRecruiter
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
