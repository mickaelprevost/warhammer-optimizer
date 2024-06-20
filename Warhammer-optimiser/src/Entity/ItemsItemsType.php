<?php

namespace App\Entity;

use App\Repository\ItemsItemsTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemsItemsTypeRepository::class)]
class ItemsItemsType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'itemsItemsTypes')]
    private ?Items $item = null;

    #[ORM\ManyToOne(inversedBy: 'itemsItemsTypes')]
    private ?Itemstype $type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItem(): ?Items
    {
        return $this->item;
    }

    public function setItem(?Items $item): static
    {
        $this->item = $item;

        return $this;
    }

    public function getType(): ?Itemstype
    {
        return $this->type;
    }

    public function setType(?Itemstype $type): static
    {
        $this->type = $type;

        return $this;
    }
}
