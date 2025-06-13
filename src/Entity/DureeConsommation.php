<?php

namespace App\Entity;

use App\Repository\DureeConsommationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DureeConsommationRepository::class)]
class DureeConsommation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $duree = null;

    /**
     * @var Collection<int, Tracabilite>
     */
    #[ORM\OneToMany(targetEntity: Tracabilite::class, mappedBy: 'duree')]
    private Collection $tracabilites;

    public function __construct()
    {
        $this->tracabilites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * @return Collection<int, Tracabilite>
     */
    public function getTracabilites(): Collection
    {
        return $this->tracabilites;
    }

    public function addTracabilite(Tracabilite $tracabilite): static
    {
        if (!$this->tracabilites->contains($tracabilite)) {
            $this->tracabilites->add($tracabilite);
            $tracabilite->setDuree($this);
        }

        return $this;
    }

    public function removeTracabilite(Tracabilite $tracabilite): static
    {
        if ($this->tracabilites->removeElement($tracabilite)) {
            // set the owning side to null (unless already changed)
            if ($tracabilite->getDuree() === $this) {
                $tracabilite->setDuree(null);
            }
        }

        return $this;
    }
}
