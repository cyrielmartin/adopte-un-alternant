<?php

namespace App\Repository;


use App\Entity\VisitCard;
use App\Entity\SearchCandidate;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method VisitCard|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisitCard|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisitCard[]    findAll()
 * @method VisitCard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisitCardRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VisitCard::class);
    }

    /**
     * @return Query
     */

     public function findAllSearchCandidateQuery()
     {
        return $this->findAll();
     
            
            


     }

    // /**
    //  * @return VisitCard[] Returns an array of VisitCard objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VisitCard
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
