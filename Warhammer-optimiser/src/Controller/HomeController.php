<?php

namespace App\Controller;

use App\Repository\ClasseRepository;
use App\Repository\FactionRepository;
use App\Repository\ItemsRepository;
use App\Repository\ItemstypeRepository;
use App\Repository\TemplateRepository;
use App\Repository\TemplateListeRepository;
use App\Repository\ItemsItemsTypeRepository;
use App\Repository\BasestatsRepository;
use App\Repository\RenownabilitiesRepository;
use App\Repository\TemplateRenownAbilitiesListeRepository;
use App\Entity\Template;
use App\Entity\TemplateListe;
use App\Entity\TemplateRenownAbilitiesListe;
use App\Entity\TemplateTalismansListe;
use App\Repository\TalismansRepository;
use App\Repository\TemplateTalismansListeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(FactionRepository $factionRepository): Response
    {
        $order = $factionRepository->findOneBy(['name' => 'order']);
        $destruction = $factionRepository->findOneBy(['name' => 'destruction']);

        return $this->render('home/index.html.twig', [
            'order' => $order,
            'destruction' => $destruction,
        ]);
    }

    #[Route('/order', name: 'app_order')]
    public function order(ClasseRepository $classeRepository): Response
    {
        $classes = $classeRepository->findBy(['Faction' => 'order']);

        return $this->render('order.html.twig', [
            'classes' => $classes,
        ]);
    }

    #[Route('/destruction', name: 'app_destruction')]
    public function destruction(ClasseRepository $classeRepository): Response
    {
        $classes = $classeRepository->findBy(['Faction' => 'destruction']);

        return $this->render('destruction.html.twig', [
            'classes' => $classes,
        ]);
    }

    #[Route('{id<\d+>}/gear', name: 'app_classe')]
    public function classe($id, ItemsRepository $itemsRepository, ItemstypeRepository $itemstypeRepository, 
    ClasseRepository $classeRepository, Request $request, ItemsItemsTypeRepository $itemsitemstypeRepository, 
    EntityManagerInterface $entityManager): Response
    {
        $classe = $classeRepository->findOneBy(['id' => $id]);
        $classeId = $classe->getId();
        $types = $itemstypeRepository->findAll();
        $liste = [];
        
        foreach ($types as $id => $type){
            $id = $type->getId();
            $liste[$id] = $itemsitemstypeRepository->findBy(['type' => $id]);
        }

        if ($request->getMethod() === 'POST') {

            $template = new Template();

            $all = $request->request->All();
            $Nom = $request->request->get('nom');
            
            foreach ($all as $item) {
                $itemsListe = $itemsRepository->findBy(['name' => $item]);
            }

            $template->setNom($Nom);
            $template->setClass($classe);
            $entityManager->persist($template);

            foreach ($itemsListe as $liste) {
                $TemplateListe = new TemplateListe();
                $TemplateListe->setItems($liste);
                $TemplateListe->setTemplate($template);
                $entityManager->persist($TemplateListe);
            }

            $entityManager->flush();
            return $this->redirectToRoute('app_classepassive', ['id' => $template->getId()]);
        }
         
        return $this->render('classe.html.twig', [
            'classe' => $classe,
            'classeId' => $classeId,
            'gear' => $liste,
            'types' => $types
        ]);
    }


    #[Route('/{id<\d+>}/passive', name: 'app_classepassive')]
    public function renown($id, RenownabilitiesRepository $renownabilitiesRepository, TemplateRepository $templateRepository,
    Request $request, EntityManagerInterface $entityManager): Response
    {
        $renownabilities = $renownabilitiesRepository->findAll();
        $template = $templateRepository->findOneby(['id' => $id]);
        $renownListe = [];
        if ($request->getMethod() === 'POST') {

            $all = $request->request->All();
        
            foreach ($all as $item) {
                $renownListe = $renownabilitiesRepository->findBy(['id' => $item]);
            }
        
            if ($renownListe !== null ) {
            foreach ($renownListe as $liste) {
                $TemplateRenownListe = new TemplateRenownAbilitiesListe();
                $TemplateRenownListe->setRenownabilities($liste);
                $TemplateRenownListe->setTemplate($template);
                $entityManager->persist($TemplateRenownListe);
            }
        }
            $entityManager->flush();
            return $this->redirectToRoute('app_gearslots', ['id' => $template->getId()]);
        }
         
        return $this->render('renown.html.twig', [
            'renownabilities' => $renownabilities,
        ]);
    }

    #[Route('/{id<\d+>}/Talismans', name: 'app_gearslots')]
    public function gemslots($id, TemplateListeRepository $templateListeRepository, TalismansRepository $talismansRepository,
    TemplateRepository $templateRepository, TemplateTalismansListeRepository $TemplateTalismansListeRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $liste = $templateListeRepository->findBy(['template' => $id]);
        $template = $templateRepository->findOneby(['id' => $id]);
        $talismanAll = $talismansRepository->findAll();
        $slotNumber = "0";

        foreach ($liste as $items) {
            $slotNumber += $items->getItems()->getslot();
            }
        
            if ($request->getMethod() === 'POST') {

                $all = $request->request->All();
                $quantities =$all['quantity'];
            

                foreach ($all['talismans'] as $item) {
                    $talismanListe[] = $talismansRepository->findBy(['name' => $item]);
                }
    
                if ($talismanListe !== null ) {
                foreach ($talismanListe as $liste) {
                    foreach ($liste as $object) {
                    $TemplateTalismansListe = new TemplateTalismansListe();
                    $TemplateTalismansListe->setTalismans($object);
                    $TemplateTalismansListe->setTemplate($template);
                    $entityManager->persist($TemplateTalismansListe);
                    }
                }  
            }
                $entityManager->flush();
                $test = $TemplateTalismansListeRepository->findBy(['template' => $id]);
                foreach ($test as $id => $liste) {
                    foreach ($quantities as $key => $quantity) {
                        if ($id == $key) { 
                            $liste->setQuantity($quantity);
                            $entityManager->persist($liste);
                        }
                    }
                }
                $entityManager->flush();
                return $this->redirectToRoute('app_template', ['id' => $template->getId()]);
            }
    
        return $this->render('talismans.html.twig', [
        'talismans' => $talismanAll,
        'TalismanSlots' => $slotNumber,
        ]);
    }

    #[Route('{id<\d+>}/results', name: 'app_template')]
    public function template($id, TemplateRepository $templateRepository, TemplateListeRepository $templateListeRepository,
    BasestatsRepository $basestatsRepository, TemplateRenownAbilitiesListeRepository $templateRenownAbilitiesRepository,
    TemplateTalismansListeRepository $templateTalismansRepository): Response
    {
        $name = $templateRepository->findOneBy(['id' => $id]);
        $liste = $templateListeRepository->findBy(['template' => $id]);
        $classeId = $name->getClass()->getId();
        /* We get all the base stat from $basetstats except for dodge disrupt parry because they depend on other stats calculation */
        $Basestats = $basestatsRepository->findOneBy(['classId' => $classeId]);
        $DodgefromInitiative = $Basestats->getInitiative() * 0.03;
        $DisruptfromWillpower = $Basestats->getWillpower() * 0.03;
        $ParryfromWeaponskill = $Basestats->getWeaponskill() * 0.03;

        $templateRenown = $templateRenownAbilitiesRepository->findBy(['template' => $id]);
        
        $talismansListe = $templateTalismansRepository->findBy(['template' => $id]);
        $Talismansintel = '0';
        $Talismanswound = '0';
        $Talismansinitiative = '0';
        $DodgeFromTalismansIni = '0';
        $Talismanstoughness = '0';
        $Talismansstrenght = '0';
        $Talismanswillpower = '0';
        $DisruptFromTalismansWill = '0';
        $Talismansweaponskill = '0';
        $ParryFromTalismansWeaponskill = '0';
        $Talismansballisticskill = '0';
        $Talismansarmor = '0';
        foreach ($talismansListe as $id => $talisman) {
            if ($id <= 1){
                $Talismansintel += $talisman->getQuantity() * $talisman->getTalismans()->getValue();
            }
            if ($id > 1 && $id <= 3){
                $Talismanswound += $talisman->getQuantity() * $talisman->getTalismans()->getValue();
            }
            if ($id > 3 && $id <= 5){
                $Talismansinitiative += $talisman->getQuantity() * $talisman->getTalismans()->getValue();
                $DodgeFromTalismansIni = $Talismansinitiative * 0.03;
            }
            if ($id > 5 && $id <= 7){
                $Talismanstoughness += $talisman->getQuantity() * $talisman->getTalismans()->getValue();
            }
            if ($id > 7 && $id <= 9){
                $Talismansstrenght += $talisman->getQuantity() * $talisman->getTalismans()->getValue();
            }
            if ($id > 9 && $id <= 11){
                $Talismanswillpower += $talisman->getQuantity() * $talisman->getTalismans()->getValue();
                $DisruptFromTalismansWill = $Talismanswillpower * 0.03;
            }
            if ($id > 11 && $id <= 13){
                $Talismansweaponskill+= $talisman->getQuantity() * $talisman->getTalismans()->getValue();
                $ParryFromTalismansWeaponskill = $Talismansweaponskill * 0.03;
            }
            if ($id > 13 && $id <= 15){
                $Talismansballisticskill += $talisman->getQuantity() * $talisman->getTalismans()->getValue();
            }
            if ($id > 15 && $id <= 17){
                $Talismansarmor += $talisman->getQuantity() * $talisman->getTalismans()->getValue();
            }
        }

        $object=[];
        $totalIntel = "0";
        $totalWound = "0";
        $totalStrenght = "0";
        $totalInitiative = "0";
        $totalToughness = "0";
        $totalResist = "0";
        $totalAP = "0";
        $totalArmor = "0";
        $totalMeleecritchance = "0";
        $totalRangedcritchance = "0";
        $totalCritheal = "0";
        $totalMagicpower = "0";
        $totalWillpower = "0";
        $totalWeaponskill= "0";
        $totalMagiccritchance = "0";
        $totalDodge = "0";
        $totalDisrupt = "0";
        $totalMorale = "0";
        $totalRegenpv= "0";
        $totalReducedarmorpen = "0";
        $totalBallisticskill= "0";
        $totalBlock = "0";
        $totalParry = "0";
        
        
        foreach ($liste as $items) {
        $object[] = $items->getItems();
        $totalAP += $items->getItems()->getAP();
        $totalArmor += $items->getItems()->getArmor();
        $totalDisrupt += $items->getItems()->getDisrupt();
        $totalDodge += $items->getItems()->getDodge();
        $totalMagiccritchance += $items->getItems()->getMagiccritchance();
        $totalMeleecritchance += $items->getItems()->getMeleecritchance();
        $totalCritheal += $items->getItems()->getCritheal();
        $totalInitiative += $items->getItems()->getInitiative();
        $totalIntel += $items->getItems()->getIntel();
        $totalMagicpower += $items->getItems()->getMagicpower();
        $totalResist += $items->getItems()->getResist();
        $totalStrenght += $items->getItems()->getStrenght();
        $totalToughness += $items->getItems()->getToughness();
        $totalWeaponskill += $items->getItems()->getWeaponskill();  
        $totalWillpower += $items->getItems()->getWillpower(); 
        $totalWound += $items->getItems()->getWound();
        $totalMorale += $items->getItems()->getMoralesec();
        $totalRegenpv += $items->getItems()->getRegen4sec();
        $totalReducedarmorpen += $items->getItems()->getReducedarmorpen();
        $totalRangedcritchance += $items->getItems()->getRangedcritchance();
        $totalBallisticskill += $items->getItems()->getBallisticskill();
        $totalBlock += $items->getItems()->getBlock();
        $totalParry += $items->getItems()->getParry();
        }
        /* in addition to flat stats from gear we do the same as basetstats, we calculate dodge disrupt parry */
        $GeardodgefromInitiative = ($totalInitiative * 0.03);
        $GeardisruptfromWillpower = ($totalWillpower* 0.03);
        $GearparryfromWeaponskill = ($totalWeaponskill* 0.03);
        
        $intel = '0';
        $wound = '0';
        $strenght = '0';
        $toughness = '0';
        $initiative = '0';
        $magiccrit= '0';
        $meleecrit = '0';
        $rangedcrit = '0';
        $healcrit = '0';
        $willpower= '0';
        $weaponskill= '0';
        $ballisticskill = '0';
        $block = '0';
        $dodgedisrupt = '0';
        $apmax= '0';
        $critreceived = '0';
        $damagedealandreceived= '0';
        $regenincrease= '0';
        $parry= '0';
        $critdamagereceived= '0';
        $sprintboost = '0';
        $movespeedonhit = '0';
        $DodgeFromRenownIni = '0';
        $DisruptFromRenownWill ='0';
        $ParryFromRenownWeaponskill= '0';
        foreach ($templateRenown as $renown) {
                if ($renown->getRenownabilities()->getType() == ("intel")) {
                    $intel += $renown->getRenownabilities()->getValue();
                }
                if ($renown->getRenownabilities()->getType() == ("wound")) {
                    $wound += $renown->getRenownabilities()->getValue();
                }
                if ($renown->getRenownabilities()->getType() == ("strenght")) {
                    $strenght += $renown->getRenownabilities()->getValue();
                }
                if ($renown->getRenownabilities()->getType() == ("toughness")) {
                    $toughness += $renown->getRenownabilities()->getValue();
                }
                if ($renown->getRenownabilities()->getType() == ("initiative")) {
                    $initiative += $renown->getRenownabilities()->getValue();
                    $DodgeFromRenownIni = $initiative * 0.03;
                }
                if ($renown->getRenownabilities()->getType() == ("willpower")) {
                    $willpower += $renown->getRenownabilities()->getValue();
                    $DisruptFromRenownWill = $willpower * 0.03;
                }
                if ($renown->getRenownabilities()->getType() == ("magiccrit")) {
                    $magiccrit += $renown->getRenownabilities()->getValue();
                }
                if ($renown->getRenownabilities()->getType() == ("meleecrit")) {
                    $meleecrit += $renown->getRenownabilities()->getValue();
                }
                if ($renown->getRenownabilities()->getType() == ("rangedcrit")) {
                    $rangedcrit += $renown->getRenownabilities()->getValue();
                }
                if ($renown->getRenownabilities()->getType() == ("healcrit")) {
                    $healcrit += $renown->getRenownabilities()->getValue();
                }
                if ($renown->getRenownabilities()->getType() == ("weaponskill")) {
                    $weaponskill += $renown->getRenownabilities()->getValue();
                    $ParryFromRenownWeaponskill = $weaponskill * 0.03;
                }
                if ($renown->getRenownabilities()->getType() == ("ballisticskill")) {
                    $ballisticskill += $renown->getRenownabilities()->getValue();
                }
                if ($renown->getRenownabilities()->getType() == ("block")) {
                    $block += $renown->getRenownabilities()->getValue();
                }
                if ($renown->getRenownabilities()->getType() == ("parry")) {
                    $parry += $renown->getRenownabilities()->getValue();
                }
                if ($renown->getRenownabilities()->getType() == ("dodgedisrupt")) {
                    $dodgedisrupt += $renown->getRenownabilities()->getValue();
                }
                if ($renown->getRenownabilities()->getType() == ("apmax")) {
                    $apmax += $renown->getRenownabilities()->getValue();
                }
                if ($renown->getRenownabilities()->getType() == ("critreceived")) {
                    $critreceived += $renown->getRenownabilities()->getValue();
                }
                if ($renown->getRenownabilities()->getType() == ("damagedealandreceived")) {
                    $damagedealandreceived += $renown->getRenownabilities()->getValue();
                }
                if ($renown->getRenownabilities()->getType() == ("regenincrease")) {
                    $regenincrease += $renown->getRenownabilities()->getValue();
                }
                if ($renown->getRenownabilities()->getType() == ("critdamagereceived")) {
                    $critdamagereceived += $renown->getRenownabilities()->getValue();
                }
                if ($renown->getRenownabilities()->getType() == ("sprintboost")) {
                    $sprintboost += $renown->getRenownabilities()->getValue();
                }
                if ($renown->getRenownabilities()->getType() == ("movespeedonhit")) {
                    $movespeedonhit += $renown->getRenownabilities()->getValue();
                }
        }

        return $this->render('template.html.twig', [
            'name' => $name,

            /* stats from renown */
            'RenownIntel' => $intel,
            'RenownWound' => $wound,
            'RenownStrenght' => $strenght,
            'RenownToughness' => $toughness,
            'RenownInitiative' => $initiative,
            'DodgefromRenownIni'=> $DodgeFromRenownIni,
            'RenownMagiccrit' => $magiccrit,
            'RenownMeleecrit' => $meleecrit,
            'RenownRangedcrit' => $rangedcrit,
            'RenownHealcrit' => $healcrit,
            'RenownWillpower' => $willpower,
            'DisruptfromRenownIni'=> $DisruptFromRenownWill,
            'RenownWeaponskill' => $weaponskill,
            'ParryfromRenownWeaponskill'=> $ParryFromRenownWeaponskill,
            'RenownBallisticskill' => $ballisticskill,
            'RenownBlock' => $block,
            'RenownDodgedisrupt' => $dodgedisrupt,
            'RenownApmax' => $apmax,
            'RenownCritreceived' => $critreceived,
            'RenownDamagedealandreceived' => $damagedealandreceived,
            'RenownRegenincrease' => $regenincrease,
            'RenownParry' => $parry,
            'RenownCritdamagereceived' => $critdamagereceived,
            'RenownSprintboost' => $sprintboost,
            'RenownMovespeedonhit' => $movespeedonhit,

            /* base stats */
            'basestats' => $Basestats,
            'dodgefrominitiative' => $DodgefromInitiative,
            'disruptfromwillpower' => $DisruptfromWillpower,
            'parryfromweaponskill' => $ParryfromWeaponskill,

            /* items liste */
            'liste' => $object,

            /* items stats */
            'armor' => $totalArmor,
            'disrupt' => $totalDisrupt + $GeardisruptfromWillpower,
            'dodge' => $totalDodge + $GeardodgefromInitiative,
            'resist' => $totalResist,
            'magicpower' => $totalMagicpower,
            'ap' => $totalAP,
            'critheal' => $totalCritheal,
            'meleecritchance' => $totalMeleecritchance,
            'magiccritchance' => $totalMagiccritchance,
            'rangedcritchance' => $totalRangedcritchance,
            'intel' => $totalIntel,
            'wound' => $totalWound,
            'initiative' => $totalInitiative,
            'toughness' => $totalToughness,
            'strenght' => $totalStrenght,
            'willpower' => $totalWillpower,
            'ballisticskill' => $totalBallisticskill,
            'block' => $totalBlock,
            'parry' => $totalParry + $GearparryfromWeaponskill,
            'weaponskill' => $totalWeaponskill,
            'morale' => $totalMorale,
            'regenpv' =>$totalRegenpv,
            'reducarmorpen' => $totalReducedarmorpen,

            /* talismans stats */
            'talismansintel' => $Talismansintel,
            'talismanswound' => $Talismanswound,         
            'talismansinitiative' => $Talismansinitiative,
            'DodgeFromTalismansIni' => $DodgeFromTalismansIni,
            'talismanstoughness' => $Talismanstoughness,
            'talismansstrenght' => $Talismansstrenght, 
            'talismanswillpower' => $Talismanswillpower,
            'DisruptFromTalismansWillpower' => $DisruptFromTalismansWill,
            'talismansweaponskill' => $Talismansweaponskill, 
            'ParryFromTalismansWeaponskill' => $ParryFromTalismansWeaponskill,
            'talismansballisticskill' => $Talismansballisticskill,
            'talismansarmor' => $Talismansarmor,
        ]);
    }
}
