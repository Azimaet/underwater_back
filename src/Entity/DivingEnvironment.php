<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\DivingEnvironmentRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: DivingEnvironmentRepository::class)]
// API Rest Operations config
/* #[ApiResource(
    normalizationContext: ['groups' => 'read:DiveTheme'],
    denormalizationContext: ['groups' => 'write:DiveTheme'],
    collectionOperations: [
        'get',
        'post' => ['security' => 'is_granted("ROLE_SUPER_ADMIN")']
    ],
    itemOperations: [
        'get',
        'delete' => ['security' => 'is_granted("ROLE_SUPER_ADMIN")'],
        'put' => ['security' => 'is_granted("ROLE_SUPER_ADMIN")']
    ]
)] */

// API GraphQL Operations config
#[ApiResource(
    graphql: [
        //queries
        'item_query' => [
            'normalization_context' => [
                'groups' => ['read:DiveTheme']
            ]
        ],
        'collection_query' => [
            'normalization_context' => [
                'groups' => ['read:DiveThemes']
            ],
            'denormalizationContext' => [
                'groups' => ['write:DiveTheme']
            ]
        ],
        //mutations
        'create' => [
            'denormalization_context' => [
                'groups' => ['write:DiveTheme']
            ],
            'security' => 'is_granted("ROLE_SUPER_ADMIN")'
        ],
        'update' => [
            'denormalization_context' => [
                'groups' => ['write:DiveTheme']
            ],
            'security' => 'is_granted("ROLE_SUPER_ADMIN")'
        ],
        'delete' => [
            'security' => 'is_granted("ROLE_SUPER_ADMIN")'
        ]
    ]
)]
class DivingEnvironment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:DiveTheme'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:DiveTheme', 'write:DiveTheme'])]
    private ?string $label = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:DiveTheme', 'write:DiveTheme'])]
    private ?string $token = null;

    #[ORM\OneToMany(mappedBy: 'divingEnvironment', targetEntity: Dive::class)]
    private Collection $dives;

    public function __construct()
    {
        $this->dives = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return Collection<int, Dive>
     */
    public function getDives(): Collection
    {
        return $this->dives;
    }

    public function addDive(Dive $dive): self
    {
        if (!$this->dives->contains($dive)) {
            $this->dives->add($dive);
            $dive->setDivingEnvironment($this);
        }

        return $this;
    }

    public function removeDive(Dive $dive): self
    {
        if ($this->dives->removeElement($dive)) {
            // set the owning side to null (unless already changed)
            if ($dive->getDivingEnvironment() === $this) {
                $dive->setDivingEnvironment(null);
            }
        }

        return $this;
    }
}
