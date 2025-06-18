<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string>
     */
    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $qualification = null;

    /**
     * @var Collection<int, NettoyageEffectue>
     */
    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: NettoyageEffectue::class, cascade: ['persist', 'remove'])]
    private Collection $nettoyageEffectues;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    public function __construct()
    {
        $this->nettoyageEffectues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials(): void
    {
        // clear temporary sensitive data if any
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getQualification(): ?string
    {
        return $this->qualification;
    }

    public function setQualification(?string $qualification): static
    {
        $this->qualification = $qualification;

        return $this;
    }

    /**
     * @return Collection<int, NettoyageEffectue>
     */
    public function getNettoyageEffectues(): Collection
    {
        return $this->nettoyageEffectues;
    }

    public function addNettoyageEffectue(NettoyageEffectue $nettoyageEffectue): static
    {
        if (!$this->nettoyageEffectues->contains($nettoyageEffectue)) {
            $this->nettoyageEffectues->add($nettoyageEffectue);
            $nettoyageEffectue->setUtilisateur($this);
        }

        return $this;
    }

    public function removeNettoyageEffectue(NettoyageEffectue $nettoyageEffectue): static
    {
        if ($this->nettoyageEffectues->removeElement($nettoyageEffectue)) {
            if ($nettoyageEffectue->getUtilisateur() === $this) {
                $nettoyageEffectue->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }
}
