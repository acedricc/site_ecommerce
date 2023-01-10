<?php

namespace App\Entity;

use App\Repository\PhotosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotosRepository::class)]
class Photos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $taille = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\ManyToOne(inversedBy: 'photos')]
    private ?Produit $images = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getImages(): ?Produit
    {
        return $this->images;
    }

    public function setImages(?Produit $images): self
    {
        $this->images = $images;

        return $this;
    }
}
