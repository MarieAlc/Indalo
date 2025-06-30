<?php

namespace App\Entity;

use App\Repository\FabricationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FabricationRepository::class)]
class Fabrication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'fabrications')]
    private ?ProduitFabrication $produit = null;

    #[ORM\ManyToOne(inversedBy: 'fabrications')]
    private ?DureeConsommation $DureeConsomation = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column]
    private ?bool $visible = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(): ?ProduitFabrication
    {
        return $this->produit;
    }

    public function setProduit(?ProduitFabrication $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

    public function getDureeConsomation(): ?DureeConsommation
    {
        return $this->DureeConsomation;
    }

    public function setDureeConsomation(?DureeConsommation $DureeConsomation): static
    {
        $this->DureeConsomation = $DureeConsomation;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): static
    {
        $this->visible = $visible;

        return $this;
    }
}
