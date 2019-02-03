<?php

namespace App\Repository;

use App\Entity\Mobility;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Mobility|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mobility|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mobility[]    findAll()
 * @method Mobility[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MobilityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Mobility::class);
    }

    // /**
    //  * @return Mobility[] Returns an array of Mobility objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Mobility
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return Query
     */

    public function findByVisitCard($visitCardId)
    {
       $qb = $this
           ->createQueryBuilder('mobility')
           ->join('mobility.visitCards', 'visitCard')
           ->addSelect('visitCard')
           ->where('visitCard.id = :visitcardId')
           ->setParameter('visitcardId', $visitCardId);
       ;

       return $qb->getQuery()->getResult();
    }
}
