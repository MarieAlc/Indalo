<?php

namespace App\Entity;

use App\Repository\NettoyageEffectueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NettoyageEffectueRepository::class)]
class NettoyageEffectue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\ManyToOne(inversedBy: 'nettoyageEffectues')]
    private ?PlanNettoyage $planNettoyage = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'nettoyageEffectue')]
    private Collection $Utilisateur;

    public function __construct()
    {
        $this->Utilisateur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }


    public function getPlanNettoyage(): ?PlanNettoyage
    {
        return $this->planNettoyage;
    }

    public function setPlanNettoyage(?PlanNettoyage $planNettoyage): static
    {
        $this->planNettoyage = $planNettoyage;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUtilisateur(): Collection
    {
        return $this->Utilisateur;
    }

    public function addUtilisateur(User $utilisateur): static
    {
        if (!$this->Utilisateur->contains($utilisateur)) {
            $this->Utilisateur->add($utilisateur);
            $utilisateur->setNettoyageEffectue($this);
        }

        return $this;
    }

    public function removeUtilisateur(User $utilisateur): static
    {
        if ($this->Utilisateur->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getNettoyageEffectue() === $this) {
                $utilisateur->setNettoyageEffectue(null);
            }
        }

        return $this;
    }

}
