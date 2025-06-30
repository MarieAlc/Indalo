<?php

namespace App\Entity;

use App\Repository\ProduitFabricationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitFabricationRepository::class)]
class ProduitFabrication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Fabrication>
     */
    #[ORM\OneToMany(targetEntity: Fabrication::class, mappedBy: 'produit')]
    private Collection $fabrications;

    public function __construct()
    {
        $this->fabrications = new ArrayCollection();
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
     * @return Collection<int, Fabrication>
     */
    public function getFabrications(): Collection
    {
        return $this->fabrications;
    }

    public function addFabrication(Fabrication $fabrication): static
    {
        if (!$this->fabrications->contains($fabrication)) {
            $this->fabrications->add($fabrication);
            $fabrication->setProduit($this);
        }

        return $this;
    }

    public function removeFabrication(Fabrication $fabrication): static
    {
        if ($this->fabrications->removeElement($fabrication)) {
            // set the owning side to null (unless already changed)
            if ($fabrication->getProduit() === $this) {
                $fabrication->setProduit(null);
            }
        }

        return $this;
    }

   
}
