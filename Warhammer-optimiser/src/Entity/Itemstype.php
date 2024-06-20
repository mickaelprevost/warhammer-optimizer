<?php

namespace App\Entity;

use App\Repository\ItemstypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemstypeRepository::class)]
class Itemstype
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
    #[ORM\OneToMany(targetEntity: Items::class, mappedBy: 'type')]
    private Collection $items;

    /**
     * @var Collection<int, ItemsItemsType>
     */
    #[ORM\OneToMany(targetEntity: ItemsItemsType::class, mappedBy: 'type')]
    private Collection $itemsItemsTypes;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->itemsItemsTypes = new ArrayCollection();
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
            $item->setType($this);
        }

        return $this;
    }

    public function removeItem(Items $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getType() === $this) {
                $item->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ItemsItemsType>
     */
    public function getItemsItemsTypes(): Collection
    {
        return $this->itemsItemsTypes;
    }

    public function addItemsItemsType(ItemsItemsType $itemsItemsType): static
    {
        if (!$this->itemsItemsTypes->contains($itemsItemsType)) {
            $this->itemsItemsTypes->add($itemsItemsType);
            $itemsItemsType->setType($this);
        }

        return $this;
    }

    public function removeItemsItemsType(ItemsItemsType $itemsItemsType): static
    {
        if ($this->itemsItemsTypes->removeElement($itemsItemsType)) {
            // set the owning side to null (unless already changed)
            if ($itemsItemsType->getType() === $this) {
                $itemsItemsType->setType(null);
            }
        }

        return $this;
    }
}
