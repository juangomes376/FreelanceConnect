<?php

namespace App\Repository;

use App\Entity\Application;
use App\Entity\Mission;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Application>
 */
class ApplicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Application::class);
    }

//    /**
//     * @return Application[] Returns an array of Application objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Application
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findByFreelancer(User $user): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.freelancer = :user')
            ->setParameter('user', $user)
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findOneByFreelancerAndMission(User $user, Mission $mission): ?Application
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.freelancer = :user')
            ->andWhere('a.mission = :mission')
            ->setParameter('user', $user)
            ->setParameter('mission', $mission)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
