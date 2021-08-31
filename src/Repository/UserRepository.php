<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }


    public function findOneByUsername($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
    * @return User[] Returns an array of User objects
    */
    public function findByDate($year, $term)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.gradterm = :term')
            ->andWhere('u.gradyear = :year')
            ->andWhere('u.progress != :progress')
            ->setParameter('year', $year)
            ->setParameter('term', $term)
            ->setParameter('progress', 'Inactive')
            ->getQuery()
            ->getResult()
            ;
    }


    public function countByMajor()
    {
        return $this->createQueryBuilder('u')
            ->join('u.major1','m1')
            ->select('count(u.id) as countMajor, m1.name as name')
            ->andWhere('u.progress = :progress')
            ->groupBy('m1.name')
            ->setParameter('progress', 'Checklist')
            ->orderBy('countMajor', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function countBySchool()
    {
        return $this->createQueryBuilder('u')
            ->join('u.school1','s1')
            ->select('count(u.id) as countSchool, s1.name as name')
            ->andWhere('u.progress = :progress')
            ->groupBy('s1.name')
            ->setParameter('progress', 'Checklist')
            ->orderBy('countSchool', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function countByProgress()
    {
        return $this->createQueryBuilder('u')
            ->select('count(u.id) as countProgress, u.progress as name')
            ->andWhere('u.progress != :progress1')
            ->andWhere('u.progress != :progress2')
            ->setParameter('progress1', 'Inactive')
            ->setParameter('progress2', 'Admin')
            ->groupBy('name')
            ->orderBy('countProgress', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function countByGrad()
    {
        return $this->createQueryBuilder('u')
            ->select('count(u.id) as countGrad, u.gradyear as year')
            ->andWhere('u.progress = :progress1')
            ->orWhere('u.progress = :progress2')
            ->setParameter('progress1', 'Checklist')
            ->setParameter('progress2', 'Alumni')
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}
