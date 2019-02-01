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

     public function findByDepartment($departments)
    {
        $qb = $this
            ->createQueryBuilder('visitCard')
            ->join('visitCard.mobilities', 'mobilities')
            ->leftJoin('mobilities.department', 'department')
            ->addSelect('mobilities')
            ->addSelect('department')
        ;

        if(count($departments) === 1)
        {
            $qb
            ->where('department.id = :dptId')
            ->setParameter('dptId', $departments[0]);
        }
        else 
        {
            $qb->add('where', $qb->expr()->in('department.id', $departments));
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
            ->andWhere('formations.obtainedAt IS NOT NULL')
            ->setParameter('awardId', $awards[0]);
        }
        else 
        {
            $qb->add('where', $qb->expr()->in('award.id', $awards));
        }

        return $qb->getQuery()->getResult();
    }
    
}
