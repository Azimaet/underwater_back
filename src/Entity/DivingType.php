<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DivingTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DivingTypeRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'read:Type'],
    collectionOperations: ['get'],
    itemOperations: ['get', 'delete', 'put', 'patch']
)]
class DivingType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:Type'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:Type'])]
    private ?string $label = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:Type'])]
    private ?string $token = null;

    #[ORM\ManyToMany(targetEntity: Dive::class, mappedBy: 'divingType')]
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
            $dive->addDivingType($this);
        }

        return $this;
    }

    public function removeDive(Dive $dive): self
    {
        if ($this->dives->removeElement($dive)) {
            $dive->removeDivingType($this);
        }

        return $this;
    }
}
