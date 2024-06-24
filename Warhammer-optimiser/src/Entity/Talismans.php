<?php

namespace App\Entity;

use App\Repository\TalismansRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TalismansRepository::class)]
class Talismans
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $value = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    /**
     * @var Collection<int, TemplateTalismansListe>
     */
    #[ORM\OneToMany(targetEntity: TemplateTalismansListe::class, mappedBy: 'talismans')]
    private Collection $templateTalismansListes;

    public function __construct()
    {
        $this->templateTalismansListes = new ArrayCollection();
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

    public function setType(string $type): static
    {
        $this->type = $type;

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
            $templateTalismansListe->setTalismans($this);
        }

        return $this;
    }

    public function removeTemplateTalismansListe(TemplateTalismansListe $templateTalismansListe): static
    {
        if ($this->templateTalismansListes->removeElement($templateTalismansListe)) {
            // set the owning side to null (unless already changed)
            if ($templateTalismansListe->getTalismans() === $this) {
                $templateTalismansListe->setTalismans(null);
            }
        }

        return $this;
    }
}
