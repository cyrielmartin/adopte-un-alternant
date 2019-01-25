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

     public function findBySkill($skills)
     {
        $qb = $this
            ->createQueryBuilder('visitCard')
            ->join('visitCard.skills', 'skill')
            ->addSelect('skill')
        ;

        if(count($skills) === 1)
        {
            $qb
            ->where('skill.id = :skillId')
            ->setParameter('skillId', $skills[0]);
        }
        else 
        {
            $qb->add('where', $qb->expr()->in('skill.id', $skills));
        }

        return $qb->getQuery()->getResult();
     }

     public function findByMobility($mobilities)
    {
        $qb = $this
            ->createQueryBuilder('visitCard')
            ->join('visitCard.mobilities', 'mobilities')
            ->addSelect('mobilities')
        ;

        if(count($mobilities) === 1)
        {
            $qb
            ->where('mobilities.id = :mobId')
            ->setParameter('mobId', $mobilities[0]);
        }
        else 
        {
            $qb->add('where', $qb->expr()->in('mobilities.id', $mobilities));
        }

        return $qb->getQuery()->getResult();
    }

    public function findByAward($awards)
    {
        $qb = $this
            ->createQueryBuilder('visitCard')
            ->join('visitCard.formations', 'formations')
            ->leftJoin('formations.awardLevel', 'award')
            ->addSelect('formations')
            ->addSelect('award')
        ;

        if(count($awards) === 1)
        {
            $qb
            ->where('award.id = :awardId')
            ->setParameter('awardId', $awards[0]);
        }
        else 
        {
            $qb->add('where', $qb->expr()->in('award.id', $awards));
        }

        return $qb->getQuery()->getResult();
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
