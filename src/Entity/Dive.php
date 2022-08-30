<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DiveRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DiveRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'read:Dive'],
    denormalizationContext: ['groups' => 'write:Dive'],
    collectionOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => [
                    'read:Dives'
                ]
            ]
        ],
        'post'
    ]
)]
class Dive
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:Dive', 'read:Dives'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::GUID)]
    #[Groups(['read:Dive', 'read:Dives', 'write:Dive'])]
    private ?string $uuid = null;

    #[ORM\Column]
    #[Groups(['read:Dive'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['read:Dive'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['read:Dive', 'read:Dives', 'write:Dive'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    #[Groups(['read:Dive', 'read:Dives', 'write:Dive'])]
    private ?int $totalTime = null;

    #[ORM\Column]
    #[Groups(['read:Dive', 'read:Dives', 'write:Dive'])]
    private ?float $maxDepth = null;

    #[ORM\Column]
    #[Groups(['read:Dive', 'read:Dives', 'write:Dive'])]
    private array $gas = [];

    #[ORM\ManyToOne(inversedBy: 'dives')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:Dive', 'read:Dives', 'write:Dive'])]
    private ?Environment $environment = null;

    #[ORM\ManyToOne(inversedBy: 'dives')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:Dive', 'read:Dives', 'write:Dive'])]
    private ?Role $role = null;

    #[ORM\ManyToMany(targetEntity: Type::class, inversedBy: 'dives')]
    #[Groups(['read:Dive', 'read:Dives', 'write:Dive'])]
    private Collection $types;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->types = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTotalTime(): ?int
    {
        return $this->totalTime;
    }

    public function setTotalTime(int $totalTime): self
    {
        $this->totalTime = $totalTime;

        return $this;
    }

    public function getMaxDepth(): ?float
    {
        return $this->maxDepth;
    }

    public function setMaxDepth(float $maxDepth): self
    {
        $this->maxDepth = $maxDepth;

        return $this;
    }

    public function getGas(): array
    {
        return $this->gas;
    }

    public function setGas(array $gas): self
    {
        $this->gas = $gas;

        return $this;
    }

    public function getEnvironment(): ?Environment
    {
        return $this->environment;
    }

    public function setEnvironment(?Environment $environment): self
    {
        $this->environment = $environment;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Type>
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(Type $type): self
    {
        if (!$this->types->contains($type)) {
            $this->types->add($type);
        }

        return $this;
    }

    public function removeType(Type $type): self
    {
        $this->types->removeElement($type);

        return $this;
    }
}
