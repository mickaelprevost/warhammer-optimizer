<?php

namespace App\Entity;

use App\Repository\TemplateTalismansListeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TemplateTalismansListeRepository::class)]
class TemplateTalismansListe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'templateTalismansListes')]
    private ?Template $template = null;

    #[ORM\ManyToOne(inversedBy: 'templateTalismansListes')]
    private ?Talismans $talismans = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemplate(): ?Template
    {
        return $this->template;
    }

    public function setTemplate(?Template $template): static
    {
        $this->template = $template;

        return $this;
    }

    public function getTalismans(): ?Talismans
    {
        return $this->talismans;
    }

    public function setTalismans(?Talismans $talismans): static
    {
        $this->talismans = $talismans;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
}
