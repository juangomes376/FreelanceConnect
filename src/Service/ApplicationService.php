<?php

namespace App\Service;

use App\Entity\Application;
use App\Entity\Mission;
use App\Entity\User;
use App\Repository\ApplicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ApplicationService
{
    public function __construct(
        private ApplicationRepository $applicationRepository,
        private EntityManagerInterface $entityManager,
        private string $cvUploadDir,
    ) {}

    public function findAll(): array
    {
        return $this->applicationRepository->findAll();
    }

    /**
     * Crée une candidature liée à une mission, upload le CV si fourni,
     * et initialise les valeurs par défaut.
     */
    public function createForMission(
        Application $application,
        Mission $mission,
        User $freelancer,
        ?UploadedFile $cvFile
    ): void {
        if ($cvFile) {
            $newFilename = uniqid() . '.' . $cvFile->guessExtension();
            $cvFile->move($this->cvUploadDir, $newFilename);
            $application->setCvFilename($newFilename);
        } else {
            $application->setCvFilename(null);
        }

        $application->setMission($mission);
        $application->setFreelancer($freelancer);
        $application->setHoursWorked(0);
        $application->setIsAdvanceAccepted(false);

        $this->entityManager->persist($application);
        $this->entityManager->flush();
    }

    public function create(Application $application): void
    {
        $this->entityManager->persist($application);
        $this->entityManager->flush();
    }

    public function save(Application $application): void
    {
        $this->entityManager->flush();
    }

    public function delete(Application $application): void
    {
        $this->entityManager->remove($application);
        $this->entityManager->flush();
    }
}
