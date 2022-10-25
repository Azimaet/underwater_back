<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\State\UserStateProcessor;
use App\Repository\UserRepository;
use ApiPlatform\Metadata\GraphQl\QueryCollection;
use ApiPlatform\Metadata\GraphQl\Query;
use ApiPlatform\Metadata\GraphQl\Mutation;
use ApiPlatform\Metadata\ApiResource;

#[
    ApiResource(graphQlOperations: [
        new Query(
            name: 'item_query',
            normalizationContext: ['groups' => ['read:User']]
        ),
        new QueryCollection(
            name: 'collection_query',
            normalizationContext: ['groups' => ['read:Users']],
            denormalizationContext: ['groups' => ['write:User']]
        ),
        new Mutation(
            name: 'create',
            denormalizationContext: ['groups' => ['write:User']],
            processor: UserStateProcessor::class
        ),
        new Mutation(
            name: 'update',
            denormalizationContext: ['groups' => ['write:User']],
            security: 'is_granted("USER_EDIT", object)',
            processor: UserStateProcessor::class
        ),
        new Mutation(
            name: 'delete',
            security: 'is_granted("USER_DELETE", object)'
        )
    ])
]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(['email'])]
#[UniqueEntity(['username'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:User', 'read:Dive'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['read:User', 'write:User'])]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['read:User'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[Groups(['write:User'])]
    #[SerializedName('password')]
    private ?string $plainPassword = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['read:User', 'write:User', 'read:Dive'])]
    #[Assert\Length(min: 3, max: 50)]
    private ?string $username = null;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Dive::class, orphanRemoval: true)]
    #[Groups(['read:User'])]
    private Collection $dives;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['write:User'])]
    private ?string $avatar = null;

    public function __construct()
    {
        $this->dives = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }
    public function hasRole(string $role): bool
    {
        return in_array($role, $this->getRoles());
    }
    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }
    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }
    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }
    public function getUsername(): ?string
    {
        return $this->username;
    }
    public function setUsername(string $username): self
    {
        $this->username = $username;
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
            $dive->setOwner($this);
        }
        return $this;
    }
    public function removeDive(Dive $dive): self
    {
        if ($this->dives->removeElement($dive)) {
            // set the owning side to null (unless already changed)
            if ($dive->getOwner() === $this) {
                $dive->setOwner(null);
            }
        }
        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }
}
