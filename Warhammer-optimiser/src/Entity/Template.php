<?php

namespace App\Entity;

use App\Repository\TemplateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TemplateRepository::class)]
class Template
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, TemplateListe>
     */
    #[ORM\OneToMany(targetEntity: TemplateListe::class, mappedBy: 'template')]
    private Collection $templateListes;

    #[ORM\ManyToOne(inversedBy: 'templates')]
    private ?Classe $class = null;

    public function __construct()
    {
        $this->templateListes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, TemplateListe>
     */
    public function getTemplateListes(): Collection
    {
        return $this->templateListes;
    }

    public function addTemplateListe(TemplateListe $templateListe): static
    {
        if (!$this->templateListes->contains($templateListe)) {
            $this->templateListes->add($templateListe);
            $templateListe->setTemplate($this);
        }

        return $this;
    }

    public function removeTemplateListe(TemplateListe $templateListe): static
    {
        if ($this->templateListes->removeElement($templateListe)) {
            // set the owning side to null (unless already changed)
            if ($templateListe->getTemplate() === $this) {
                $templateListe->setTemplate(null);
            }
        }

        return $this;
    }

    public function getClass(): ?Classe
    {
        return $this->class;
    }

    public function setClass(?Classe $class): static
    {
        $this->class = $class;

        return $this;
    }
}
