<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use DateTimeImmutable;
use App\Validator\SumOfRanges;
use App\State\DiveStateProcessor;
use App\Repository\DiveRepository;
use ApiPlatform\Metadata\GraphQl\QueryCollection;
use ApiPlatform\Metadata\GraphQl\Query;
use ApiPlatform\Metadata\GraphQl\Mutation;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;

#[
    ApiResource(graphQlOperations: [
        new Query(
            name: 'item_query',
            normalizationContext: ['groups' => ['read:Dive']]
        ),
        new QueryCollection(
            name: 'collection_query',
            normalizationContext: ['groups' => ['read:Dives']],
            denormalizationContext: ['groups' => ['write:Dive']]
        ),
        new Mutation(
            name: 'create',
            denormalizationContext: ['groups' => ['write:Dive']],
            security: 'is_granted("ROLE_USER")',
            processor: DiveStateProcessor::class
        ),
        new Mutation(
            name: 'update',
            denormalizationContext: ['groups' => ['write:Dive']],
            security: 'is_granted("DIVE_EDIT", object)',
            processor: DiveStateProcessor::class
        ),
        new Mutation(
            name: 'delete',
            security: 'is_granted("DIVE_DELETE", object)'
        )
    ])
]

#[ORM\Entity(repositoryClass: DiveRepository::class)]
#[ApiFilter(SearchFilter::class, properties: ['owner' => 'exact'])]
#[ApiFilter(OrderFilter::class, properties: ['date'], arguments: ['orderParameterName' => 'order'])]
class Dive
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:Dive', 'read:Dives', 'read:User'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::GUID)]
    #[Groups(['read:Dive', 'read:Dives'])]
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
    #[Assert\All([
        new Assert\Collection([
            'pressureStart' => new Assert\Type('integer'),
            'pressureEnd' => new Assert\Type('integer'),
            'gasMix' => [
                new SumOfRanges(limit: 100),
                new Assert\Collection([
                    'oxygen' => [
                        new Assert\Type('integer'),
                        new Assert\Range(min: 0, max: 100)
                    ],
                    'nitrogen' => [
                        new Assert\Type('integer'),
                        new Assert\Range(min: 0, max: 100)
                    ],
                    'helium' => [
                        new Assert\Type('integer'),
                        new Assert\Range(min: 0, max: 100)
                    ]
                ])
            ]
        ]),
    ])]
    private array $gasTanks = [];

    #[ORM\ManyToMany(targetEntity: DivingType::class, inversedBy: 'dives')]
    #[Groups(['read:Dive', 'read:Dives', 'write:Dive'])]
    private Collection $divingType;

    #[ORM\ManyToOne(inversedBy: 'dives')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:Dive', 'read:Dives', 'write:Dive'])]
    private ?DivingEnvironment $divingEnvironment = null;

    #[ORM\ManyToOne(inversedBy: 'dives')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:Dive', 'read:Dives', 'write:Dive'])]
    private ?DivingRole $divingRole = null;

    #[ORM\ManyToOne(inversedBy: 'dives')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:Dive'])]
    private ?User $owner = null;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->divingType = new ArrayCollection();
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

    public function getGasTanks(): array
    {
        return $this->gasTanks;
    }

    public function setGasTanks(array $gasTanks): self
    {
        $this->gasTanks = $gasTanks;

        return $this;
    }

    /**
     * @return Collection<int, DivingType>
     */
    public function getDivingType(): Collection
    {
        return $this->divingType;
    }

    public function addDivingType(DivingType $divingType): self
    {
        if (!$this->divingType->contains($divingType)) {
            $this->divingType->add($divingType);
        }

        return $this;
    }

    public function removeDivingType(DivingType $divingType): self
    {
        $this->divingType->removeElement($divingType);

        return $this;
    }

    public function getDivingEnvironment(): ?DivingEnvironment
    {
        return $this->divingEnvironment;
    }

    public function setDivingEnvironment(?DivingEnvironment $divingEnvironment): self
    {
        $this->divingEnvironment = $divingEnvironment;

        return $this;
    }

    public function getDivingRole(): ?DivingRole
    {
        return $this->divingRole;
    }

    public function setDivingRole(?DivingRole $divingRole): self
    {
        $this->divingRole = $divingRole;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
