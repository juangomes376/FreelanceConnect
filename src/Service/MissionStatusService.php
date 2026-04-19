<?php

namespace App\Service;

use App\Entity\MissionStatus;
use App\Repository\MissionStatusRepository;
use Doctrine\ORM\EntityManagerInterface;

class MissionStatusService
{
    public function __construct(
        private MissionStatusRepository $missionStatusRepository,
        private EntityManagerInterface $entityManager,
    ) {}

    public function findAll(): array
    {
        return $this->missionStatusRepository->findAll();
    }

    public function create(MissionStatus $missionStatus): void
    {
        $this->entityManager->persist($missionStatus);
        $this->entityManager->flush();
    }

    public function save(MissionStatus $missionStatus): void
    {
        $this->entityManager->flush();
    }

    public function delete(MissionStatus $missionStatus): void
    {
        $this->entityManager->remove($missionStatus);
        $this->entityManager->flush();
    }
}
