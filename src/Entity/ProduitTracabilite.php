<?php

namespace App\Entity;

use App\Repository\ProduitTracabiliteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitTracabiliteRepository::class)]
class ProduitTracabilite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Tracabilite>
     */
    #[ORM\OneToMany(targetEntity: Tracabilite::class, mappedBy: 'produit')]
    private Collection $tracabilites;

    public function __construct()
    {
        $this->tracabilites = new ArrayCollection();
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
            $tracabilite->setProduit($this);
        }

        return $this;
    }

    public function removeTracabilite(Tracabilite $tracabilite): static
    {
        if ($this->tracabilites->removeElement($tracabilite)) {
            // set the owning side to null (unless already changed)
            if ($tracabilite->getProduit() === $this) {
                $tracabilite->setProduit(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom ?? '';
    }

}
