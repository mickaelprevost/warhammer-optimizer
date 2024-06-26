<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Items>
     */
    #[ORM\OneToMany(targetEntity: Items::class, mappedBy: 'classe')]
    private Collection $items;

    #[ORM\Column(length: 255)]
    private ?string $Faction = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    /**
     * @var Collection<int, Template>
     */
    #[ORM\OneToMany(targetEntity: Template::class, mappedBy: 'class')]
    private Collection $templates;

    /**
     * @var Collection<int, Sets>
     */
    #[ORM\OneToMany(targetEntity: Sets::class, mappedBy: 'classe')]
    private Collection $sets;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->templates = new ArrayCollection();
        $this->sets = new ArrayCollection();
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

    /**
     * @return Collection<int, Items>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Items $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setClasse($this);
        }

        return $this;
    }

    public function removeItem(Items $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getClasse() === $this) {
                $item->setClasse(null);
            }
        }

        return $this;
    }

    public function getFaction(): ?string
    {
        return $this->Faction;
    }

    public function setFaction(string $Faction): static
    {
        $this->Faction = $Faction;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection<int, Template>
     */
    public function getTemplates(): Collection
    {
        return $this->templates;
    }

    public function addTemplate(Template $template): static
    {
        if (!$this->templates->contains($template)) {
            $this->templates->add($template);
            $template->setClass($this);
        }

        return $this;
    }

    public function removeTemplate(Template $template): static
    {
        if ($this->templates->removeElement($template)) {
            // set the owning side to null (unless already changed)
            if ($template->getClass() === $this) {
                $template->setClass(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sets>
     */
    public function getSets(): Collection
    {
        return $this->sets;
    }

    public function addSet(Sets $set): static
    {
        if (!$this->sets->contains($set)) {
            $this->sets->add($set);
            $set->setClasse($this);
        }

        return $this;
    }

    public function removeSet(Sets $set): static
    {
        if ($this->sets->removeElement($set)) {
            // set the owning side to null (unless already changed)
            if ($set->getClasse() === $this) {
                $set->setClasse(null);
            }
        }

        return $this;
    }
}
