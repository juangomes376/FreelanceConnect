<?php

namespace App\Service;

use App\Entity\ApplicationStatus;
use App\Repository\ApplicationStatusRepository;
use Doctrine\ORM\EntityManagerInterface;

class ApplicationStatusService
{
    public function __construct(
        private ApplicationStatusRepository $applicationStatusRepository,
        private EntityManagerInterface $entityManager,
    ) {}

    public function findAll(): array
    {
        return $this->applicationStatusRepository->findAll();
    }

    public function create(ApplicationStatus $applicationStatus): void
    {
        $this->entityManager->persist($applicationStatus);
        $this->entityManager->flush();
    }

    public function save(ApplicationStatus $applicationStatus): void
    {
        $this->entityManager->flush();
    }

    public function delete(ApplicationStatus $applicationStatus): void
    {
        $this->entityManager->remove($applicationStatus);
        $this->entityManager->flush();
    }
}
