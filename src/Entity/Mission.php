<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'missions')]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'missions')]
    private ?Language $language = null;

    #[ORM\ManyToOne(inversedBy: 'missions')]
    private ?User $client = null;

    #[ORM\ManyToOne(inversedBy: 'missions')]
    private ?User $freelance = null;

    /**
     * @var Collection<int, Application>
     */
    #[ORM\OneToMany(targetEntity: Application::class, mappedBy: 'mission')]
    private Collection $applications;

    #[ORM\ManyToOne(inversedBy: 'missions')]
    private ?MissionStatus $status = null;

    public function __construct()
    {
        $this->applications = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getFreelance(): ?User
    {
        return $this->freelance;
    }

    public function setFreelance(?User $freelance): static
    {
        $this->freelance = $freelance;

        return $this;
    }

    /**
     * @return Collection<int, Application>
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): static
    {
        if (!$this->applications->contains($application)) {
            $this->applications->add($application);
            $application->setMission($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): static
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getMission() === $this) {
                $application->setMission(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?MissionStatus
    {
        return $this->status;
    }

    public function setStatus(?MissionStatus $status): static
    {
        $this->status = $status;

        return $this;
    }
}
