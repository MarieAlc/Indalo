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
     * @var Collection<int, Fabrication>
     */
    #[ORM\OneToMany(targetEntity: Fabrication::class, mappedBy: 'DureeConsomation')]
    private Collection $fabrications;

    public function __construct()
    {

        $this->fabrications = new ArrayCollection();
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
            $fabrication->setDureeConsomation($this);
        }

        return $this;
    }

    public function removeFabrication(Fabrication $fabrication): static
    {
        if ($this->fabrications->removeElement($fabrication)) {
            // set the owning side to null (unless already changed)
            if ($fabrication->getDureeConsomation() === $this) {
                $fabrication->setDureeConsomation(null);
            }
        }

        return $this;
    }
}
