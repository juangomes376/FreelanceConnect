<?php

namespace App\Service;

use App\Entity\Mission;
use App\Entity\User;
use App\Repository\MissionRepository;
use Doctrine\ORM\EntityManagerInterface;


class MissionService
{
    public function __construct(
        private MissionRepository $missionRepository,
        private EntityManagerInterface $entityManager,
    ) {}

    public function findAll(): array
    {
        return $this->missionRepository->findAll();
    }

    public function create(Mission $mission, User $client): void
    {
        $mission->setIsValidatedByAdmin(false);
        $mission->setNeedsRevalidation(false);
        $mission->setClient($client);

        $this->entityManager->persist($mission);
        $this->entityManager->flush();
    }

    public function save(Mission $mission): void
    {
        $this->entityManager->flush();
    }

    public function delete(Mission $mission): void
    {
        $this->entityManager->remove($mission);
        $this->entityManager->flush();
    }
}
