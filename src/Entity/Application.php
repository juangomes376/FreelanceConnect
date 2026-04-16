<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToOne(inversedBy: 'applications')]
    private ?Mission $mission = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    private ?User $freelancer = null;

    /**
     * @var Collection<int, Invoice>
     */
    #[ORM\OneToMany(targetEntity: Invoice::class, mappedBy: 'application')]
    private Collection $invoices;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    private ?ApplicationStatus $status = null;

    public function __construct()
    {
        $this->invoices = new ArrayCollection();
    }

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

    public function getMission(): ?Mission
    {
        return $this->mission;
    }

    public function setMission(?Mission $mission): static
    {
        $this->mission = $mission;

        return $this;
    }

    public function getFreelancer(): ?User
    {
        return $this->freelancer;
    }

    public function setFreelancer(?User $freelancer): static
    {
        $this->freelancer = $freelancer;

        return $this;
    }

    /**
     * @return Collection<int, Invoice>
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): static
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices->add($invoice);
            $invoice->setApplication($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): static
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getApplication() === $this) {
                $invoice->setApplication(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?ApplicationStatus
    {
        return $this->status;
    }

    public function setStatus(?ApplicationStatus $status): static
    {
        $this->status = $status;

        return $this;
    }
}
