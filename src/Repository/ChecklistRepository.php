<?php

namespace App\Repository;

use App\Entity\Checklist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Checklist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Checklist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Checklist[]    findAll()
 * @method Checklist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChecklistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Checklist::class);
    }

    public function countByAnchor()
    {
        return $this->createQueryBuilder('c')
            ->join('c.anchor','a')
            ->select('count(c.id) as countCourse, a.name as name')
            ->groupBy('a.name')
            ->orderBy('countCourse', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function countBySphere1()
    {
        return $this->createQueryBuilder('c')
            ->join('c.sphere1','a')
            ->select('count(c.id) as countCourse, a.name as name')
            ->groupBy('a.name')
            ->orderBy('countCourse', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function countBySphere2()
    {
        return $this->createQueryBuilder('c')
            ->join('c.sphere2','a')
            ->select('count(c.id) as countCourse, a.name as name')
            ->groupBy('a.name')
            ->orderBy('countCourse', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function countBySphere3()
    {
        return $this->createQueryBuilder('c')
            ->join('c.sphere3','a')
            ->select('count(c.id) as countCourse, a.name as name')
            ->groupBy('a.name')
            ->orderBy('countCourse', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function countBySeminar()
    {
        return $this->createQueryBuilder('c')
            ->join('c.seminar','a')
            ->select('count(c.id) as countCourse, a.name as name')
            ->groupBy('a.name')
            ->orderBy('countCourse', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }


}
