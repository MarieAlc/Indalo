<?php

namespace App\Entity;

use App\Repository\TracabiliteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TracabiliteRepository::class)]
class Tracabilite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255,  nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $date = null;

    #[ORM\ManyToOne(inversedBy: 'tracabilites')]
    private ?ProduitTracabilite $produit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(): ?ProduitTracabilite
    {
        return $this->produit;
    }

    public function setProduit(?ProduitTracabilite $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

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

    
    public function __construct(){
        $this->date = new \DateTimeImmutable(); 
    }
}
