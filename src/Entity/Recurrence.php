<?php

namespace App\Entity;

use App\Repository\RecurrenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecurrenceRepository::class)]
class Recurrence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column]
    private ?int $intervalleJour = null;

    /**
     * @var Collection<int, PlanNettoyage>
     */
    #[ORM\OneToMany(targetEntity: PlanNettoyage::class, mappedBy: 'reccurence')]
    private Collection $planNettoyages;

    public function __construct()
    {
        $this->planNettoyages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getIntervalleJour(): ?int
    {
        return $this->intervalleJour;
    }

    public function setIntervalleJour(int $intervalleJour): static
    {
        $this->intervalleJour = $intervalleJour;

        return $this;
    }

    /**
     * @return Collection<int, PlanNettoyage>
     */
    public function getPlanNettoyages(): Collection
    {
        return $this->planNettoyages;
    }

    public function addPlanNettoyage(PlanNettoyage $planNettoyage): static
    {
        if (!$this->planNettoyages->contains($planNettoyage)) {
            $this->planNettoyages->add($planNettoyage);
            $planNettoyage->setReccurence($this);
        }

        return $this;
    }

    public function removePlanNettoyage(PlanNettoyage $planNettoyage): static
    {
        if ($this->planNettoyages->removeElement($planNettoyage)) {
            // set the owning side to null (unless already changed)
            if ($planNettoyage->getReccurence() === $this) {
                $planNettoyage->setReccurence(null);
            }
        }

        return $this;
    }
}
