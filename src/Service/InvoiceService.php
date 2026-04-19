<?php

namespace App\Service;

use App\Entity\Invoice;
use App\Repository\InvoiceRepository;
use Doctrine\ORM\EntityManagerInterface;

class InvoiceService
{
    public function __construct(
        private InvoiceRepository $invoiceRepository,
        private EntityManagerInterface $entityManager,
    ) {}

    public function findAll(): array
    {
        return $this->invoiceRepository->findAll();
    }

    public function create(Invoice $invoice): void
    {
        $this->entityManager->persist($invoice);
        $this->entityManager->flush();
    }

    public function save(Invoice $invoice): void
    {
        $this->entityManager->flush();
    }

    public function delete(Invoice $invoice): void
    {
        $this->entityManager->remove($invoice);
        $this->entityManager->flush();
    }
}
