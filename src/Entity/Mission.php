<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MissionRepository::class)]
class Mission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $budget = null;

    #[ORM\Column]
    private ?\DateTime $deadline = null;

    #[ORM\Column]
    private ?bool $isValidatedByAdmin = null;

    #[ORM\Column]
    private ?bool $needsRevalidation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getBudget(): ?string
    {
        return $this->budget;
    }

    public function setBudget(string $budget): static
    {
        $this->budget = $budget;

        return $this;
    }

    public function getDeadline(): ?\DateTime
    {
        return $this->deadline;
    }

    public function setDeadline(\DateTime $deadline): static
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function isValidatedByAdmin(): ?bool
    {
        return $this->isValidatedByAdmin;
    }

    public function setIsValidatedByAdmin(bool $isValidatedByAdmin): static
    {
        $this->isValidatedByAdmin = $isValidatedByAdmin;

        return $this;
    }

    public function isNeedsRevalidation(): ?bool
    {
        return $this->needsRevalidation;
    }

    public function setNeedsRevalidation(bool $needsRevalidation): static
    {
        $this->needsRevalidation = $needsRevalidation;

        return $this;
    }
}
