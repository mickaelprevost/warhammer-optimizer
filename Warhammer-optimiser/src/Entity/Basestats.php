<?php

namespace App\Entity;

use App\Repository\BasestatsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BasestatsRepository::class)]
class Basestats
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $strenght = null;

    #[ORM\Column]
    private ?int $ballisticskill = null;

    #[ORM\Column]
    private ?int $intel = null;

    #[ORM\Column]
    private ?int $toughness = null;

    #[ORM\Column]
    private ?int $weaponskill = null;

    #[ORM\Column]
    private ?int $initiative = null;

    #[ORM\Column]
    private ?int $willpower = null;

    #[ORM\Column]
    private ?int $wound = null;

    #[ORM\Column(nullable: true)]
    private ?int $armor = null;

    #[ORM\Column(nullable: true)]
    private ?int $resist = null;

    #[ORM\Column(nullable: true)]
    private ?int $block = null;

    #[ORM\Column(nullable: true)]
    private ?int $parry = null;

    #[ORM\Column(nullable: true)]
    private ?int $dodge = null;

    #[ORM\Column(nullable: true)]
    private ?int $disrupt = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Classe $classId = null;

    #[ORM\Column(nullable: true)]
    private ?int $magicpower = null;

    #[ORM\Column(nullable: true)]
    private ?int $ap = null;

    #[ORM\Column(nullable: true)]
    private ?int $critheal = null;

    #[ORM\Column(nullable: true)]
    private ?int $magiccritchance = null;

    #[ORM\Column(nullable: true)]
    private ?int $meleecritchance = null;

    #[ORM\Column(nullable: true)]
    private ?int $rangedcritchance = null;

    #[ORM\Column(nullable: true)]
    private ?int $meleepower = null;

    #[ORM\Column(nullable: true)]
    private ?int $rangedpower = null;

    #[ORM\Column(nullable: true)]
    private ?int $healpower = null;

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

    public function getStrenght(): ?int
    {
        return $this->strenght;
    }

    public function setStrenght(int $strenght): static
    {
        $this->strenght = $strenght;

        return $this;
    }

    public function getBallisticskill(): ?int
    {
        return $this->ballisticskill;
    }

    public function setBallisticskill(int $ballisticskill): static
    {
        $this->ballisticskill = $ballisticskill;

        return $this;
    }

    public function getIntel(): ?int
    {
        return $this->intel;
    }

    public function setIntel(int $intel): static
    {
        $this->intel = $intel;

        return $this;
    }

    public function getToughness(): ?int
    {
        return $this->toughness;
    }

    public function setToughness(int $toughness): static
    {
        $this->toughness = $toughness;

        return $this;
    }

    public function getWeaponskill(): ?int
    {
        return $this->weaponskill;
    }

    public function setWeaponskill(int $weaponskill): static
    {
        $this->weaponskill = $weaponskill;

        return $this;
    }

    public function getInitiative(): ?int
    {
        return $this->initiative;
    }

    public function setInitiative(int $initiative): static
    {
        $this->initiative = $initiative;

        return $this;
    }

    public function getWillpower(): ?int
    {
        return $this->willpower;
    }

    public function setWillpower(int $willpower): static
    {
        $this->willpower = $willpower;

        return $this;
    }

    public function getWound(): ?int
    {
        return $this->wound;
    }

    public function setWound(int $wound): static
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

    public function getResist(): ?int
    {
        return $this->resist;
    }

    public function setResist(?int $resist): static
    {
        $this->resist = $resist;

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

    public function getClassId(): ?Classe
    {
        return $this->classId;
    }

    public function setClassId(Classe $classId): static
    {
        $this->classId = $classId;

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

    public function getCritheal(): ?int
    {
        return $this->critheal;
    }

    public function setCritheal(?int $critheal): static
    {
        $this->critheal = $critheal;

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

    public function getMeleecritchance(): ?int
    {
        return $this->meleecritchance;
    }

    public function setMeleecritchance(?int $meleecritchance): static
    {
        $this->meleecritchance = $meleecritchance;

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

    public function getMeleepower(): ?int
    {
        return $this->meleepower;
    }

    public function setMeleepower(?int $meleepower): static
    {
        $this->meleepower = $meleepower;

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

    public function getHealpower(): ?int
    {
        return $this->healpower;
    }

    public function setHealpower(int $healpower): static
    {
        $this->healpower = $healpower;

        return $this;
    }
}
