<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $qualification = null;

    #[ORM\Column(length: 255)]
    private ?string $motDePasse = null;

    #[ORM\Column(length: 255)]
    private ?string $nomUtilisateur = null;

    #[ORM\Column]
    private ?bool $admin = null;

    /**
     * @var Collection<int, NettoyageEffectue>
     */
    #[ORM\OneToMany(targetEntity: NettoyageEffectue::class, mappedBy: 'utilisateur')]
    private Collection $nettoyageEffectues;

    public function __construct()
    {
        $this->nettoyageEffectues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getQualification(): ?string
    {
        return $this->qualification;
    }

    public function setQualification(string $qualification): static
    {
        $this->qualification = $qualification;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): static
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getNomUtilisateur(): ?string
    {
        return $this->nomUtilisateur;
    }

    public function setNomUtilisateur(string $nomUtilisateur): static
    {
        $this->nomUtilisateur = $nomUtilisateur;

        return $this;
    }

    public function isAdmin(): ?bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): static
    {
        $this->admin = $admin;

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
            // set the owning side to null (unless already changed)
            if ($nettoyageEffectue->getUtilisateur() === $this) {
                $nettoyageEffectue->setUtilisateur(null);
            }
        }

        return $this;
    }
}
