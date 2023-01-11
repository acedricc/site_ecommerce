<?php

namespace App\Entity;

use App\Repository\TailleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TailleRepository::class)]
class Taille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 3)]
    private ?string $taillelettre = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 2)]
    private ?string $taillechaussure = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaillelettre(): ?string
    {
        return $this->taillelettre;
    }

    public function setTaillelettre(string $taillelettre): self
    {
        $this->taillelettre = $taillelettre;

        return $this;
    }

    public function getTaillechaussure(): ?string
    {
        return $this->taillechaussure;
    }

    public function setTaillechaussure(string $taillechaussure): self
    {
        $this->taillechaussure = $taillechaussure;

        return $this;
    }
}
