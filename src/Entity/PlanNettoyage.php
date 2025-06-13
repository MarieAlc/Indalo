<?php

namespace App\Entity;

use App\Repository\PlanNettoyageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanNettoyageRepository::class)]
class PlanNettoyage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'planNettoyages')]
    private ?Recurrence $reccurence = null;

    /**
     * @var Collection<int, NettoyageEffectue>
     */
    #[ORM\OneToMany(targetEntity: NettoyageEffectue::class, mappedBy: 'planNettoyage')]
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

    public function getReccurence(): ?Recurrence
    {
        return $this->reccurence;
    }

    public function setReccurence(?Recurrence $reccurence): static
    {
        $this->reccurence = $reccurence;

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
            $nettoyageEffectue->setPlanNettoyage($this);
        }

        return $this;
    }

    public function removeNettoyageEffectue(NettoyageEffectue $nettoyageEffectue): static
    {
        if ($this->nettoyageEffectues->removeElement($nettoyageEffectue)) {
            // set the owning side to null (unless already changed)
            if ($nettoyageEffectue->getPlanNettoyage() === $this) {
                $nettoyageEffectue->setPlanNettoyage(null);
            }
        }

        return $this;
    }
}
