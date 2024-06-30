<?php

namespace App\Entity;

use App\Repository\ItemsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemsRepository::class)]
class Items
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $intel = null;

    #[ORM\Column(nullable: true)]
    private ?int $strenght = null;

    #[ORM\Column(nullable: true)]
    private ?int $initiative = null;

    #[ORM\Column(nullable: true)]
    private ?int $willpower = null;

    #[ORM\Column(nullable: true)]
    private ?int $toughness = null;

    #[ORM\Column(nullable: true)]
    private ?int $wound = null;

    #[ORM\Column(nullable: true)]
    private ?int $armor = null;

    #[ORM\Column(nullable: true)]
    private ?int $meleecritchance = null;

    #[ORM\Column(nullable: true)]
    private ?int $critheal = null;

    #[ORM\Column(nullable: true)]
    private ?int $resist = null;

    #[ORM\Column(nullable: true)]
    private ?int $magicpower = null;

    #[ORM\Column(nullable: true)]
    private ?int $ap = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?Classe $classe = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?Sets $sets = null;

    /**
     * @var Collection<int, TemplateListe>
     */
    #[ORM\OneToMany(targetEntity: TemplateListe::class, mappedBy: 'items')]
    private Collection $templateListes;

    #[ORM\Column(nullable: true)]
    private ?int $weaponskill = null;

    #[ORM\Column(nullable: true)]
    private ?int $magiccritchance = null;

    #[ORM\Column(nullable: true)]
    private ?int $dodge = null;

    #[ORM\Column(nullable: true)]
    private ?int $disrupt = null;

    /**
     * @var Collection<int, ItemsItemsType>
     */
    #[ORM\OneToMany(targetEntity: ItemsItemsType::class, mappedBy: 'item')]
    private Collection $itemsItemsTypes;

    #[ORM\Column(nullable: true)]
    private ?int $reducedarmorpen = null;

    #[ORM\Column(nullable: true)]
    private ?int $regen4sec = null;

    #[ORM\Column(nullable: true)]
    private ?int $moralesec = null;

    #[ORM\Column(nullable: true)]
    private ?int $rangedcritchance = null;

    #[ORM\Column(nullable: true)]
    private ?int $ballisticskill = null;

    #[ORM\Column(nullable: true)]
    private ?int $block = null;

    #[ORM\Column(nullable: true)]
    private ?int $parry = null;

    #[ORM\Column(nullable: true)]
    private ?int $slot = null;

    #[ORM\Column(nullable: true)]
    private ?int $meleepower = null;

    #[ORM\Column(nullable: true)]
    private ?int $healpower = null;

    #[ORM\Column(nullable: true)]
    private ?int $rangedpower = null;

    #[ORM\Column(nullable: true)]
    private ?int $reduceddisrupt = null;

    #[ORM\Column(nullable: true)]
    private ?int $autoattackspeed = null;

    #[ORM\Column(nullable: true)]
    private ?int $reducedparry = null;

    public function __construct()
    {
        $this->templateListes = new ArrayCollection();
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

    public function getIntel(): ?int
    {
        return $this->intel;
    }

    public function setIntel(?int $intel): static
    {
        $this->intel = $intel;

        return $this;
    }

    public function getStrenght(): ?int
    {
        return $this->strenght;
    }

    public function setStrenght(?int $strenght): static
    {
        $this->strenght = $strenght;

        return $this;
    }

    public function getInitiative(): ?int
    {
        return $this->initiative;
    }

    public function setInitiative(?int $initiative): static
    {
        $this->initiative = $initiative;

        return $this;
    }

    public function getWillpower(): ?int
    {
        return $this->willpower;
    }

    public function setWillpower(?int $willpower): static
    {
        $this->willpower = $willpower;

        return $this;
    }

    public function getToughness(): ?int
    {
        return $this->toughness;
    }

    public function setToughness(?int $toughness): static
    {
        $this->toughness = $toughness;

        return $this;
    }

    public function getWound(): ?int
    {
        return $this->wound;
    }

    public function setWound(?int $wound): static
    {
        $this->wound = $wound;

        return $this;
    }

    public function getArmor(): ?int
    {
        return $this->armor;
    }

    public function setArmor(?int $armor): static
    {
        $this->armor = $armor;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): static
    {
        $this->classe = $classe;

        return $this;
    }

    public function getSets(): ?Sets
    {
        return $this->sets;
    }

    public function setSets(?Sets $sets): static
    {
        $this->sets = $sets;

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
            $templateListe->setItems($this);
        }

        return $this;
    }

    public function removeTemplateListe(TemplateListe $templateListe): static
    {
        if ($this->templateListes->removeElement($templateListe)) {
            // set the owning side to null (unless already changed)
            if ($templateListe->getItems() === $this) {
                $templateListe->setItems(null);
            }
        }

        return $this;
    }

    public function getMeleecritchance(): ?int
    {
        return $this->meleecritchance;
    }

    public function setMeleecritchance(?int $meleecritchance): static
    {
        $this->meleecritchance = $meleecritchance;

        return $this;
    }

    public function getCritheal(): ?int
    {
        return $this->critheal;
    }

    public function setCritheal(?int $critheal): static
    {
        $this->critheal = $critheal;

        return $this;
    }

    public function getResist(): ?int
    {
        return $this->resist;
    }

    public function setResist(?int $resist): static
    {
        $this->resist = $resist;

        return $this;
    }

    public function getMagicpower(): ?int
    {
        return $this->magicpower;
    }

    public function setMagicpower(?int $magicpower): static
    {
        $this->magicpower = $magicpower;

        return $this;
    }

    public function getAp(): ?int
    {
        return $this->ap;
    }

    public function setAp(?int $ap): static
    {
        $this->ap = $ap;

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

    public function getWeaponskill(): ?int
    {
        return $this->weaponskill;
    }

    public function setWeaponskill(?int $weaponskill): static
    {
        $this->weaponskill = $weaponskill;

        return $this;
    }

    public function getMagiccritchance(): ?int
    {
        return $this->magiccritchance;
    }

    public function setMagiccritchance(?int $magiccritchance): static
    {
        $this->magiccritchance = $magiccritchance;

        return $this;
    }

    public function getDodge(): ?int
    {
        return $this->dodge;
    }

    public function setDodge(?int $dodge): static
    {
        $this->dodge = $dodge;

        return $this;
    }

    public function getDisrupt(): ?int
    {
        return $this->disrupt;
    }

    public function setDisrupt(?int $disrupt): static
    {
        $this->disrupt = $disrupt;

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
            $itemsItemsType->setItem($this);
        }

        return $this;
    }

    public function removeItemsItemsType(ItemsItemsType $itemsItemsType): static
    {
        if ($this->itemsItemsTypes->removeElement($itemsItemsType)) {
            // set the owning side to null (unless already changed)
            if ($itemsItemsType->getItem() === $this) {
                $itemsItemsType->setItem(null);
            }
        }

        return $this;
    }

    public function getReducedarmorpen(): ?int
    {
        return $this->reducedarmorpen;
    }

    public function setReducedarmorpen(?int $reducedarmorpen): static
    {
        $this->reducedarmorpen = $reducedarmorpen;

        return $this;
    }

    public function getRegen4sec(): ?int
    {
        return $this->regen4sec;
    }

    public function setRegen4sec(?int $regen4sec): static
    {
        $this->regen4sec = $regen4sec;

        return $this;
    }

    public function getMoralesec(): ?int
    {
        return $this->moralesec;
    }

    public function setMoralesec(?int $moralesec): static
    {
        $this->moralesec = $moralesec;

        return $this;
    }

    public function getRangedcritchance(): ?int
    {
        return $this->rangedcritchance;
    }

    public function setRangedcritchance(?int $rangedcritchance): static
    {
        $this->rangedcritchance = $rangedcritchance;

        return $this;
    }

    public function getBallisticskill(): ?int
    {
        return $this->ballisticskill;
    }

    public function setBallisticskill(?int $ballisticskill): static
    {
        $this->ballisticskill = $ballisticskill;

        return $this;
    }

    public function getBlock(): ?int
    {
        return $this->block;
    }

    public function setBlock(?int $block): static
    {
        $this->block = $block;

        return $this;
    }

    public function getParry(): ?int
    {
        return $this->parry;
    }

    public function setParry(?int $parry): static
    {
        $this->parry = $parry;

        return $this;
    }

    public function getSlot(): ?int
    {
        return $this->slot;
    }

    public function setSlot(?int $slot): static
    {
        $this->slot = $slot;

        return $this;
    }

    public function getMeleepower(): ?int
    {
        return $this->meleepower;
    }

    public function setMeleepower(?int $meleepower): static
    {
        $this->meleepower = $meleepower;

        return $this;
    }

    public function getHealpower(): ?int
    {
        return $this->healpower;
    }

    public function setHealpower(?int $healpower): static
    {
        $this->healpower = $healpower;

        return $this;
    }

    public function getRangedpower(): ?int
    {
        return $this->rangedpower;
    }

    public function setRangedpower(?int $rangedpower): static
    {
        $this->rangedpower = $rangedpower;

        return $this;
    }

    public function getReduceddisrupt(): ?int
    {
        return $this->reduceddisrupt;
    }

    public function setReduceddisrupt(?int $reduceddisrupt): static
    {
        $this->reduceddisrupt = $reduceddisrupt;

        return $this;
    }

    public function getAutoattackspeed(): ?int
    {
        return $this->autoattackspeed;
    }

    public function setAutoattackspeed(?int $autoattackspeed): static
    {
        $this->autoattackspeed = $autoattackspeed;

        return $this;
    }

    public function getReducedparry(): ?int
    {
        return $this->reducedparry;
    }

    public function setReducedparry(?int $reducedparry): static
    {
        $this->reducedparry = $reducedparry;

        return $this;
    }
}
