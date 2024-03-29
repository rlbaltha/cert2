<?php

namespace App\Repository;

use App\Entity\Substitution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Substitution|null find($id, $lockMode = null, $lockVersion = null)
 * @method Substitution|null findOneBy(array $criteria, array $orderBy = null)
 * @method Substitution[]    findAll()
 * @method Substitution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubstitutionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Substitution::class);
    }

    // /**
    //  * @return Substitution[] Returns an array of Substitution objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Substitution
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
