<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $coverLetter = null;

    #[ORM\Column(length: 255)]
    private ?string $cvFilename = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $portfolioLinks = null;

    #[ORM\Column]
    private ?int $hoursWorked = null;

    #[ORM\Column]
    private ?int $advanceRequestedPercent = null;

    #[ORM\Column]
    private ?bool $isAdvanceAccepted = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoverLetter(): ?string
    {
        return $this->coverLetter;
    }

    public function setCoverLetter(string $coverLetter): static
    {
        $this->coverLetter = $coverLetter;

        return $this;
    }

    public function getCvFilename(): ?string
    {
        return $this->cvFilename;
    }

    public function setCvFilename(string $cvFilename): static
    {
        $this->cvFilename = $cvFilename;

        return $this;
    }

    public function getPortfolioLinks(): ?string
    {
        return $this->portfolioLinks;
    }

    public function setPortfolioLinks(string $portfolioLinks): static
    {
        $this->portfolioLinks = $portfolioLinks;

        return $this;
    }

    public function getHoursWorked(): ?int
    {
        return $this->hoursWorked;
    }

    public function setHoursWorked(int $hoursWorked): static
    {
        $this->hoursWorked = $hoursWorked;

        return $this;
    }

    public function getAdvanceRequestedPercent(): ?int
    {
        return $this->advanceRequestedPercent;
    }

    public function setAdvanceRequestedPercent(int $advanceRequestedPercent): static
    {
        $this->advanceRequestedPercent = $advanceRequestedPercent;

        return $this;
    }

    public function isAdvanceAccepted(): ?bool
    {
        return $this->isAdvanceAccepted;
    }

    public function setIsAdvanceAccepted(bool $isAdvanceAccepted): static
    {
        $this->isAdvanceAccepted = $isAdvanceAccepted;

        return $this;
    }
}
