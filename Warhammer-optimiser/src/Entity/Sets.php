<?php

namespace App\Entity;

use App\Repository\SetsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SetsRepository::class)]
class Sets
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
    #[ORM\OneToMany(targetEntity: Items::class, mappedBy: 'sets')]
    private Collection $items;

    /**
     * @var Collection<int, Setbonuses>
     */
    #[ORM\OneToMany(targetEntity: Setbonuses::class, mappedBy: 'sets')]
    private Collection $setbonuses;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->setbonuses = new ArrayCollection();
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
            $item->setSets($this);
        }

        return $this;
    }

    public function removeItem(Items $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getSets() === $this) {
                $item->setSets(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Setbonuses>
     */
    public function getSetbonuses(): Collection
    {
        return $this->setbonuses;
    }

    public function addSetbonus(Setbonuses $setbonus): static
    {
        if (!$this->setbonuses->contains($setbonus)) {
            $this->setbonuses->add($setbonus);
            $setbonus->setSets($this);
        }

        return $this;
    }

    public function removeSetbonus(Setbonuses $setbonus): static
    {
        if ($this->setbonuses->removeElement($setbonus)) {
            // set the owning side to null (unless already changed)
            if ($setbonus->getSets() === $this) {
                $setbonus->setSets(null);
            }
        }

        return $this;
    }
}
