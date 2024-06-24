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

    /**
     * @var Collection<int, TemplateRenownAbilitiesListe>
     */
    #[ORM\OneToMany(targetEntity: TemplateRenownAbilitiesListe::class, mappedBy: 'template')]
    private Collection $templateRenownAbilitiesListes;

    /**
     * @var Collection<int, TemplateTalismansListe>
     */
    #[ORM\OneToMany(targetEntity: TemplateTalismansListe::class, mappedBy: 'template')]
    private Collection $templateTalismansListes;

    public function __construct()
    {
        $this->templateListes = new ArrayCollection();
        $this->templateRenownAbilitiesListes = new ArrayCollection();
        $this->templateTalismansListes = new ArrayCollection();
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
            $templateRenownAbilitiesListe->setTemplate($this);
        }

        return $this;
    }

    public function removeTemplateRenownAbilitiesListe(TemplateRenownAbilitiesListe $templateRenownAbilitiesListe): static
    {
        if ($this->templateRenownAbilitiesListes->removeElement($templateRenownAbilitiesListe)) {
            // set the owning side to null (unless already changed)
            if ($templateRenownAbilitiesListe->getTemplate() === $this) {
                $templateRenownAbilitiesListe->setTemplate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TemplateTalismansListe>
     */
    public function getTemplateTalismansListes(): Collection
    {
        return $this->templateTalismansListes;
    }

    public function addTemplateTalismansListe(TemplateTalismansListe $templateTalismansListe): static
    {
        if (!$this->templateTalismansListes->contains($templateTalismansListe)) {
            $this->templateTalismansListes->add($templateTalismansListe);
            $templateTalismansListe->setTemplate($this);
        }

        return $this;
    }

    public function removeTemplateTalismansListe(TemplateTalismansListe $templateTalismansListe): static
    {
        if ($this->templateTalismansListes->removeElement($templateTalismansListe)) {
            // set the owning side to null (unless already changed)
            if ($templateTalismansListe->getTemplate() === $this) {
                $templateTalismansListe->setTemplate(null);
            }
        }

        return $this;
    }
}
