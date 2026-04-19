<?php

namespace App\Repository;

use App\Entity\Mission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mission>
 */
class MissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mission::class);
    }

    /**
     * @return Mission[]
     */
    public function findRecentPublished(int $limit = 5): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.isValidatedByAdmin = :validated')
            ->setParameter('validated', true)
            ->orderBy('m.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Mission[]
     */
    public function findAllPublished(): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.isValidatedByAdmin = :validated')
            ->setParameter('validated', true)
            ->orderBy('m.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
