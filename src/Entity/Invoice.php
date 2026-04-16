<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $invoiceNumber = null;

    #[ORM\Column(length: 14)]
    private ?string $senderSiret = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $amountHT = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $tvaRate = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $amountTVA = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $amountTTC = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $label = null;

    #[ORM\Column(length: 20)]
    private ?string $type = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'invoices')]
    private ?Application $application = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvoiceNumber(): ?string
    {
        return $this->invoiceNumber;
    }

    public function setInvoiceNumber(string $invoiceNumber): static
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    public function getSenderSiret(): ?string
    {
        return $this->senderSiret;
    }

    public function setSenderSiret(string $senderSiret): static
    {
        $this->senderSiret = $senderSiret;

        return $this;
    }

    public function getAmountHT(): ?string
    {
        return $this->amountHT;
    }

    public function setAmountHT(string $amountHT): static
    {
        $this->amountHT = $amountHT;

        return $this;
    }

    public function getTvaRate(): ?string
    {
        return $this->tvaRate;
    }

    public function setTvaRate(string $tvaRate): static
    {
        $this->tvaRate = $tvaRate;

        return $this;
    }

    public function getAmountTVA(): ?string
    {
        return $this->amountTVA;
    }

    public function setAmountTVA(string $amountTVA): static
    {
        $this->amountTVA = $amountTVA;

        return $this;
    }

    public function getAmountTTC(): ?string
    {
        return $this->amountTTC;
    }

    public function setAmountTTC(string $amountTTC): static
    {
        $this->amountTTC = $amountTTC;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getApplication(): ?Application
    {
        return $this->application;
    }

    public function setApplication(?Application $application): static
    {
        $this->application = $application;

        return $this;
    }
}
