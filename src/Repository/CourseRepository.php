<?php

namespace App\Repository;

use App\Entity\Course;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }


    /**
     * find course by sphere
     *
     * @return Course[]
     */
    public function findForChecklist($sphere) {
        if ($sphere == 'Seminar' or $sphere == 'Capstone')
        {
            return $this->createQueryBuilder('c')
                ->andWhere('c.sphere = :sphere')
                ->andWhere('c.status = :status')
                ->setParameter('sphere', $sphere)
                ->setParameter('status', 'Approved')
                ->orderBy('c.name ')
                ->getQuery()
                ->getResult();
        }
        else {
            return $this->createQueryBuilder('c')
                ->andWhere('c.sphere = :sphere or c.sphere = :any')
                ->andWhere('c.status = :status')
                ->setParameter('sphere', $sphere)
                ->setParameter('any', 'Any')
                ->setParameter('status', 'Approved')
                ->orderBy('c.name ')
                ->getQuery()
                ->getResult();
        }

    }

    /**
     * find course by sphere
     *
     * @return Course[]
     */
    public function findByType($sphere, $level) {
        if ($sphere == 'Seminar' or $sphere == 'Capstone') {
            return $this->createQueryBuilder('c')
                ->andWhere('c.sphere = :sphere')
                ->andWhere('c.level = :level or c.level = :split')
                ->andWhere('c.status = :status')
                ->setParameter('sphere', $sphere)
                ->setParameter('level', $level)
                ->setParameter('split', 'Split')
                ->setParameter('status', 'Approved')
                ->orderBy('c.name ')
                ->getQuery()
                ->getResult();
        }
        else {
            return $this->createQueryBuilder('c')
                ->andWhere('c.sphere = :sphere or c.sphere = :any')
                ->andWhere('c.level = :level or c.level = :split')
                ->andWhere('c.status = :status')
                ->setParameter('sphere', $sphere)
                ->setParameter('any', 'Any')
                ->setParameter('level', $level)
                ->setParameter('split', 'Split')
                ->setParameter('status', 'Approved')
                ->orderBy('c.name ')
                ->getQuery()
                ->getResult();
        }
    }

    public function findBySphere($sphere)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.sphere = :val')
            ->setParameter('val', $sphere)
            ->orderBy('c.name ')
            ->getQuery()
            ->getResult();
    }

    public function groupBySphere()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.name ')
            ->groupBy('c.sphere')
            ->getQuery()
            ->getResult();
    }

    public function countByAnchor()
    {
        return $this->createQueryBuilder('c')
            ->join('c.anchor_courses','a')
            ->select('count(a.id) as countCourse, c.name as name, c.id as id')
            ->groupBy('c.id')
            ->orderBy('countCourse', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function countBySphere1()
    {
        return $this->createQueryBuilder('c')
            ->join('c.sphere1_courses','a')
            ->select('count(a.id) as countCourse, c.name as name, c.id as id')
            ->groupBy('c.id')
            ->orderBy('countCourse', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function countBySphere2()
    {
        return $this->createQueryBuilder('c')
            ->join('c.sphere2_courses','a')
            ->select('count(a.id) as countCourse, c.name as name, c.id as id')
            ->groupBy('c.id')
            ->orderBy('countCourse', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function countBySphere3()
    {
        return $this->createQueryBuilder('c')
            ->join('c.sphere3_courses','a')
            ->select('count(a.id) as countCourse, c.name as name, c.id as id')
            ->groupBy('c.id')
            ->orderBy('countCourse', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function countBySeminar()
    {
        return $this->createQueryBuilder('c')
            ->join('c.seminars','a')
            ->select('count(a.id) as countCourse, c.name as name, c.id as id')
            ->groupBy('c.id')
            ->orderBy('countCourse', 'DESC')
            ->getQuery()
            ->getResult();
    }

}
