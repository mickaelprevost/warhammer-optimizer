<?php

namespace App\Entity;

use App\Repository\RenownabilitiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RenownabilitiesRepository::class)]
class Renownabilities
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $cost = null;

    #[ORM\Column(nullable: true)]
    private ?int $value = null;

    /**
     * @var Collection<int, TemplateRenownAbilitiesListe>
     */
    #[ORM\OneToMany(targetEntity: TemplateRenownAbilitiesListe::class, mappedBy: 'Renownabilities')]
    private Collection $templateRenownAbilitiesListes;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    public function __construct()
    {
        $this->templateRenownAbilitiesListes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(?int $cost): static
    {
        $this->cost = $cost;

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

    /**
     * @return Collection<int, TemplateRenownAbilitiesListe>
     */
    public function getTemplateRenownAbilitiesListes(): Collection
    {
        return $this->templateRenownAbilitiesListes;
    }

    public function addTemplateRenownAbilitiesListe(TemplateRenownAbilitiesListe $templateRenownAbilitiesListe): static
    {
        if (!$this->templateRenownAbilitiesListes->contains($templateRenownAbilitiesListe)) {
            $this->templateRenownAbilitiesListes->add($templateRenownAbilitiesListe);
            $templateRenownAbilitiesListe->setRenownabilities($this);
        }

        return $this;
    }

    public function removeTemplateRenownAbilitiesListe(TemplateRenownAbilitiesListe $templateRenownAbilitiesListe): static
    {
        if ($this->templateRenownAbilitiesListes->removeElement($templateRenownAbilitiesListe)) {
            // set the owning side to null (unless already changed)
            if ($templateRenownAbilitiesListe->getRenownabilities() === $this) {
                $templateRenownAbilitiesListe->setRenownabilities(null);
            }
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }
}
