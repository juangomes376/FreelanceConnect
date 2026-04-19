<?php

namespace App\Service;

use App\Entity\Language;
use App\Repository\LanguageRepository;
use Doctrine\ORM\EntityManagerInterface;

class LanguageService
{
    public function __construct(
        private LanguageRepository $languageRepository,
        private EntityManagerInterface $entityManager,
    ) {}

    public function findAll(): array
    {
        return $this->languageRepository->findAll();
    }

    public function create(Language $language): void
    {
        $this->entityManager->persist($language);
        $this->entityManager->flush();
    }

    public function save(Language $language): void
    {
        $this->entityManager->flush();
    }

    public function delete(Language $language): void
    {
        $this->entityManager->remove($language);
        $this->entityManager->flush();
    }
}
