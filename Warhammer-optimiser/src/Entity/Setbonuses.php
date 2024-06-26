<?php

namespace App\Entity;

use App\Repository\SetbonusesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SetbonusesRepository::class)]
class Setbonuses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'setbonuses')]
    private ?Sets $sets = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $value = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?int $parts = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSets(): ?Sets
    {
        return $this->sets;
    }

    public function setSets(?Sets $sets): static
    {
        $this->sets = $sets;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(?int $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getParts(): ?int
    {
        return $this->parts;
    }

    public function setParts(?int $parts): static
    {
        $this->parts = $parts;

        return $this;
    }
}
