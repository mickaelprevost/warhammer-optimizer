<?php

namespace App\Entity;

use App\Repository\TemplateRenownAbilitiesListeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TemplateRenownAbilitiesListeRepository::class)]
class TemplateRenownAbilitiesListe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'templateRenownAbilitiesListes')]
    private ?Template $template = null;

    #[ORM\ManyToOne(inversedBy: 'templateRenownAbilitiesListes')]
    private ?Renownabilities $Renownabilities = null;

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

    public function getRenownabilities(): ?Renownabilities
    {
        return $this->Renownabilities;
    }

    public function setRenownabilities(?Renownabilities $Renownabilities): static
    {
        $this->Renownabilities = $Renownabilities;

        return $this;
    }
}
