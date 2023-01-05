<?php

namespace App\Entity;

use App\Repository\BlogRepository;


#[ORM\Entity(repositoryClass: BlogRepository::class)]

class Info{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;

    #[ORM\Column(length: 20)]
}