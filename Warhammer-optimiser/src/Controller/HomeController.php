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
use App\Repository\SetbonusesRepository;
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

    #[Route('/order/races', name: 'app_order_races')]
    public function orderRaces(): Response
    {

        return $this->render('order factions.html.twig');
    }

    #[Route('/destruction/races', name: 'app_destruction_races')]
    public function destructionRaces(): Response
    {

        return $this->render('destruction factions.html.twig');
    }

    #[Route('/destruction/chaos', name: 'app_destruction_chaos')]
    public function chaos(ClasseRepository $classeRepository): Response
    {
        $classes = $classeRepository->findBy(['Faction' => 'destruction']);

        return $this->render('chaos.html.twig', [
            'classes' => $classes,
        ]);
    }

    #[Route('/destruction/darkelf', name: 'app_destruction_darkelf')]
    public function darkelf(ClasseRepository $classeRepository): Response
    {
        $classes = $classeRepository->findBy(['Faction' => 'destruction']);

        return $this->render('darkelf.html.twig', [
            'classes' => $classes,
        ]);
    }

    #[Route('/destruction/greenskins', name: 'app_destruction_greenskins')]
    public function greenskins(ClasseRepository $classeRepository): Response
    {
        $classes = $classeRepository->findBy(['Faction' => 'destruction']);

        return $this->render('greenskins.html.twig', [
            'classes' => $classes,
        ]);
    }

    #[Route('/order/highelf', name: 'app_order_highelf')]
    public function highelf(ClasseRepository $classeRepository): Response
    {
        $classes = $classeRepository->findBy(['Faction' => 'order']);

        return $this->render('highelf.html.twig', [
            'classes' => $classes,
        ]);
    }

    #[Route('/order/empire', name: 'app_order_empire')]
    public function empire(ClasseRepository $classeRepository): Response
    {
        $classes = $classeRepository->findBy(['Faction' => 'order']);

        return $this->render('empire.html.twig', [
            'classes' => $classes,
        ]);
    }

    #[Route('/order/dwarf', name: 'app_order_dwarf')]
    public function dwarf(ClasseRepository $classeRepository): Response
    {
        $classes = $classeRepository->findBy(['Faction' => 'order']);

        return $this->render('dwarf.html.twig', [
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
    TemplateTalismansListeRepository $templateTalismansRepository, SetbonusesRepository $SetbonusesRepository,
    ItemsRepository $itemsRepository): Response
    {
        $name = $templateRepository->findOneBy(['id' => $id]);
        $templateclass = $name->getClass()->getName();
        $liste = $templateListeRepository->findBy(['template' => $name]);
        
        /* foreach ($liste as $key => $item) {
            if ($item->getItems()->getSets() !== null) {
            $key = $item->getItems()->getSets()->getId();
            $tous[] = $item;
            $items[$key] = $tous;
        }
        } */

        /* !!!!!!!!!!!!!!!!!!!!!!!!!!! GESTION DES BONUS DE SET !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! */
            $nehekharanstat = [];
            $nehekharanintel = '0';
            $nehekharanwound = '0';
            $nehekharanstrenght = '0';
            $nehekharaninitiative= '0';
            $nehekharantoughness= '0';
            $nehekharanwillpower = '0';
            $nehekharanballisticskill = '0';
            $nehekharanweaponskill = '0';
            $nehekharanmeleecritchance = '0';
            $nehekharanrangedcritchance = '0';
            $nehekharanmagiccritchance = '0';
            $nehekharanhealcritchance = '0';
            $nehekharanreduceddisruptchance = '0';
            $nehekharanmagicpower = '0';
            $nehekharanmeleepower = '0';
            $nehekharanrangedpower = '0';
            $nehekharanhealpower = '0';
            $nehekharanarmor = '0';
            $nehekharanblock= '0';
            $nehekharanparry = '0';
            $nehekharandodge = '0';
            $nehekharandisrupt = '0';
            $nehekharandamage = '0';
            $nehekharancritdamage = '0';
            $nehekharanreduccriticallyhitchance = '0';
            $nehekharanreducarmorpen = '0';
            $nehekharanarmorpenetration = '0';
            $nehekharanreducparredchance = '0';
            $nehekharanautoattackspeed = '0';

            $sovereignstat = [];
            $sovereignintel = '0';
            $sovereignwound = '0';
            $sovereignstrenght = '0';
            $sovereigninitiative= '0';
            $sovereigntoughness= '0';
            $sovereignwillpower = '0';
            $sovereignballisticskill = '0';
            $sovereignweaponskill = '0';
            $sovereignmeleecritchance = '0';
            $sovereignrangedcritchance = '0';
            $sovereignmagiccritchance = '0';
            $sovereignhealcritchance = '0';
            $sovereignreduceddisruptchance = '0';
            $sovereignmagicpower = '0';
            $sovereignmeleepower = '0';
            $sovereignrangedpower = '0';
            $sovereignhealpower = '0';
            $sovereignarmor = '0';
            $sovereignblock= '0';
            $sovereignparry = '0';
            $sovereigndodge = '0';
            $sovereigndisrupt = '0';
            $sovereigndamage = '0';
            $sovereigncritdamage = '0';
            $sovereignreduccriticallyhitchance = '0';
            $sovereignreducarmorpen = '0';
            $sovereignarmorpenetration = '0';
            $sovereignreducparredchance = '0';
            $sovereignautoattackspeed = '0';

            $warlordstat = [];
            $warlordintel = '0';
            $warlordwound = '0';
            $warlordstrenght = '0';
            $warlordinitiative= '0';
            $warlordtoughness= '0';
            $warlordwillpower = '0';
            $warlordballisticskill = '0';
            $warlordweaponskill = '0';
            $warlordmeleecritchance = '0';
            $warlordrangedcritchance = '0';
            $warlordmagiccritchance = '0';
            $warlordhealcritchance = '0';
            $warlordreduceddisruptchance = '0';
            $warlordmagicpower = '0';
            $warlordmeleepower = '0';
            $warlordrangedpower = '0';
            $warlordhealpower = '0';
            $warlordarmor = '0';
            $warlordblock= '0';
            $warlordparry = '0';
            $warlorddodge = '0';
            $warlorddisrupt = '0';
            $warlorddamage = '0';
            $warlordcritdamage = '0';
            $warlordreduccriticallyhitchance = '0';
            $warlordreducarmorpen = '0';
            $warlordarmorpenetration = '0';
            $warlordreducparredchance = '0';
            $warlordautoattackspeed = '0';

            $genesisstat = [];
            $genesisintel = '0';
            $genesiswound = '0';
            $genesisstrenght = '0';
            $genesisinitiative= '0';
            $genesistoughness= '0';
            $genesiswillpower = '0';
            $genesisballisticskill = '0';
            $genesisweaponskill = '0';
            $genesismeleecritchance = '0';
            $genesisrangedcritchance = '0';
            $genesismagiccritchance = '0';
            $genesishealcritchance = '0';
            $genesisreduceddisruptchance = '0';
            $genesismagicpower = '0';
            $genesismeleepower = '0';
            $genesisrangedpower = '0';
            $genesishealpower = '0';
            $genesisarmor = '0';
            $genesisblock= '0';
            $genesisparry = '0';
            $genesisdodge = '0';
            $genesisdisrupt = '0';
            $genesisdamage = '0';
            $genesiscritdamage = '0';
            $genesisreduccriticallyhitchance = '0';
            $genesisreducarmorpen = '0';
            $genesisarmorpenetration = '0';
            $genesisreducparredchance = '0';
            $genesisautoattackspeed = '0';

            
            $victoriousstat = [];
            $victoriousintel = '0';
            $victoriouswound = '0';
            $victoriousstrenght = '0';
            $victoriousinitiative= '0';
            $victorioustoughness= '0';
            $victoriouswillpower = '0';
            $victoriousballisticskill = '0';
            $victoriousweaponskill = '0';
            $victoriousmeleecritchance = '0';
            $victoriousrangedcritchance = '0';
            $victoriousmagiccritchance = '0';
            $victorioushealcritchance = '0';
            $victoriousreduceddisruptchance = '0';
            $victoriousmagicpower = '0';
            $victoriousmeleepower = '0';
            $victoriousrangedpower = '0';
            $victorioushealpower = '0';
            $victoriousarmor = '0';
            $victoriousblock= '0';
            $victoriousparry = '0';
            $victoriousdodge = '0';
            $victoriousdisrupt = '0';
            $victoriousdamage = '0';
            $victoriouscritdamage = '0';
            $victoriousreduccriticallyhitchance = '0';
            $victoriousreducarmorpen = '0';
            $victoriousarmorpenetration = '0';
            $victoriousreducparredchance = '0';
            $victoriousautoattackspeed = '0';
        
        /* 
        resist    ap/sec   morale  regenpv 
        */
        
        foreach ($liste as $item) {
            if ($item->getItems()->getSets() !== null) {
                $classe = $item->getItems()->getClasse()->getName();
                $set = $item->getItems()->getSets();
                if ($item->getItems()->getSets()->getName() == 'sovereign - ' . $classe){
                    $sovereignBonuses = $SetbonusesRepository->findBy(['sets' => $set]);
                    $sovereign[] = $item;
                    $sovereignnumber = count($sovereign);
                    $sovereignactivebonuses = array_slice($sovereignBonuses, 0, $sovereignnumber -1);
                    if ($sovereignactivebonuses !== []) {
                        foreach ($sovereignactivebonuses as $key => $bonuses) {
                            $key = $bonuses->getType();
                            $sovereignstat[$key] = $bonuses->getValue();
                            if (array_key_exists('intel', $sovereignstat)){
                                $sovereignintel = $sovereignstat['intel'];
                            } 
                            if (array_key_exists('wound', $sovereignstat)){
                                $sovereignwound = $sovereignstat['wound'];
                            } 
                            if (array_key_exists('strenght', $sovereignstat)){
                                $sovereignstrenght = $sovereignstat['strenght'];
                            } 
                            if (array_key_exists('initiative', $sovereignstat)){
                                $sovereigninitiative = $sovereignstat['initiative'];
                            }
                            if (array_key_exists('toughness', $sovereignstat)){
                                $sovereigntoughness= $sovereignstat['toughness'];
                            } 
                            if (array_key_exists('willpower', $sovereignstat)){
                                $sovereignwillpower= $sovereignstat['willpower'];
                            } 
                            if (array_key_exists('ballistic skill', $sovereignstat)){
                                $sovereignballisticskill = $sovereignstat['ballistic skill'];
                            } 
                            if (array_key_exists('weapon skill', $sovereignstat)){
                                $sovereignweaponskill= $sovereignstat['weapon skill'];
                            }
                            if (array_key_exists('melee crit chance', $sovereignstat)){
                                $sovereignmeleecritchance = $sovereignstat['melee crit chance'];
                            } 
                            if (array_key_exists('ranged crit chance', $sovereignstat)){
                                $sovereignrangedcritchance = $sovereignstat['ranged crit chance'];
                            } 
                            if (array_key_exists('magic crit chance', $sovereignstat)){
                                $sovereignmagiccritchance = $sovereignstat['magic crit chance'];
                            } 
                            if (array_key_exists('heal crit chance', $sovereignstat)){
                                $sovereignhealcritchance = $sovereignstat['heal crit chance'];
                            } 
                            if (array_key_exists('reduced disrupt', $sovereignstat)){
                                $sovereignreduceddisruptchance = $sovereignstat['reduced disrupt'];
                            } 
                            if (array_key_exists('magic power', $sovereignstat)){
                                $sovereignmagicpower= $sovereignstat['magic power'];
                            } 
                            if (array_key_exists('melee power', $sovereignstat)){
                                $sovereignmeleepower= $sovereignstat['melee power'];
                            } 
                            if (array_key_exists('heal power', $sovereignstat)){
                                $sovereignhealpower= $sovereignstat['heal power'];
                            } 
                            if (array_key_exists('ranged power', $sovereignstat)){
                                $sovereignrangedpower= $sovereignstat['ranged power'];
                            } 
                            if (array_key_exists('armor', $sovereignstat)){
                                $sovereignarmor = $sovereignstat['armor'];
                            } 
                            if (array_key_exists('block', $sovereignstat)){
                                $sovereignblock = $sovereignstat['block'];
                            }
                            if (array_key_exists('parry', $sovereignstat)){
                                $sovereignparry = $sovereignstat['parry'];
                            }
                            if (array_key_exists('dodge', $sovereignstat)){
                                $sovereigndodge = $sovereignstat['dodge'];
                            }
                            if (array_key_exists('disrupt', $sovereignstat)){
                                $sovereigndisrupt = $sovereignstat['disrupt'];
                            }
                            if (array_key_exists('damage', $sovereignstat)){
                                $sovereigndamage = $sovereignstat['damage'];
                            }
                            if (array_key_exists('crit damage', $sovereignstat)){
                                $sovereigncritdamage = $sovereignstat['crit damage'];
                            }
                            if (array_key_exists('reduc critically hit chance', $sovereignstat)){
                                $sovereignreduccriticallyhitchance = $sovereignstat['reduc critically hit chance'];
                            }
                            if (array_key_exists('reduc armor pen', $sovereignstat)){
                                $sovereignreducarmorpen = $sovereignstat['reduc armor pen'];
                            }
                            if (array_key_exists('armor penetration', $sovereignstat)){
                                $sovereignarmorpenetration = $sovereignstat['armor penetration'];
                            }
                            if (array_key_exists('reduc parred chance', $sovereignstat)){
                                $sovereignreducparredchance = $sovereignstat['reduc parred chance'];
                            }
                            if (array_key_exists('auto attack speed', $sovereignstat)){
                                $sovereignautoattackspeed = $sovereignstat['auto attack speed'];
                            }
                        }
                    } 
                }
        
                if ($item->getItems()->getSets()->getName() == 'warlord - ' . $classe){
                    $warlordBonuses = $SetbonusesRepository->findBy(['sets' => $set]);
                    $warlord[] = $item;
                    $warlordnumber = count($warlord);
                    $warlordactivebonuses = array_slice($warlordBonuses, 0, $warlordnumber - 1);
                    if ($warlordactivebonuses !== []) {
                        foreach ($warlordactivebonuses as $key => $bonuses) {
                            $key = $bonuses->getType();
                            $warlordstat[$key] = $bonuses->getValue();
                            if (array_key_exists('intel', $warlordstat)){
                                $warlordintel = $warlordstat['intel'];
                            } 
                            if (array_key_exists('wound', $warlordstat)){
                                $warlordwound = $warlordstat['wound'];
                            } 
                            if (array_key_exists('strenght', $warlordstat)){
                                $warlordstrenght = $warlordstat['strenght'];
                            } 
                            if (array_key_exists('initiative', $warlordstat)){
                                $warlordinitiative = $warlordstat['initiative'];
                            }
                            if (array_key_exists('toughness', $warlordstat)){
                                $warlordtoughness= $warlordstat['toughness'];
                            } 
                            if (array_key_exists('willpower', $warlordstat)){
                                $warlordwillpower= $warlordstat['willpower'];
                            } 
                            if (array_key_exists('ballistic skill', $warlordstat)){
                                $warlordballisticskill = $warlordstat['ballistic skill'];
                            } 
                            if (array_key_exists('weapon skill', $warlordstat)){
                                $warlordweaponskill= $warlordstat['weapon skill'];
                            }
                            if (array_key_exists('melee crit chance', $warlordstat)){
                                $warlordmeleecritchance = $warlordstat['melee crit chance'];
                            } 
                            if (array_key_exists('ranged crit chance', $warlordstat)){
                                $warlordrangedcritchance = $warlordstat['ranged crit chance'];
                            } 
                            if (array_key_exists('magic crit chance', $warlordstat)){
                                $warlordmagiccritchance = $warlordstat['magic crit chance'];
                            } 
                            if (array_key_exists('heal crit chance', $warlordstat)){
                                $warlordhealcritchance = $warlordstat['heal crit chance'];
                            } 
                            if (array_key_exists('reduced disrupt', $warlordstat)){
                                $warlordreduceddisruptchance = $warlordstat['reduced disrupt'];
                            } 
                            if (array_key_exists('magic power', $warlordstat)){
                                $warlordmagicpower= $warlordstat['magic power'];
                            } 
                            if (array_key_exists('melee power', $warlordstat)){
                                $warlordmeleepower= $warlordstat['melee power'];
                            } 
                            if (array_key_exists('ranged power', $warlordstat)){
                                $warlordrangedpower= $warlordstat['ranged power'];
                            } 
                            if (array_key_exists('heal power', $warlordstat)){
                                $warlordhealpower= $warlordstat['heal power'];
                            } 
                            if (array_key_exists('armor', $warlordstat)){
                                $warlordarmor = $warlordstat['armor'];
                            } 
                            if (array_key_exists('block', $warlordstat)){
                                $warlordblock = $warlordstat['block'];
                            }
                            if (array_key_exists('parry', $warlordstat)){
                                $warlordparry = $warlordstat['parry'];
                            }
                            if (array_key_exists('dodge', $warlordstat)){
                                $warlorddodge = $warlordstat['dodge'];
                            }
                            if (array_key_exists('disrupt', $warlordstat)){
                                $warlorddisrupt = $warlordstat['disrupt'];
                            }
                            if (array_key_exists('damage', $warlordstat)){
                                $warlorddamage = $warlordstat['damage'];
                            }
                            if (array_key_exists('crit damage', $warlordstat)){
                                $warlordcritdamage = $warlordstat['crit damage'];
                            }
                            if (array_key_exists('reduc critically hit chance', $warlordstat)){
                                $warlordreduccriticallyhitchance = $warlordstat['reduc critically hit chance'];
                            }
                            if (array_key_exists('reduc armor pen', $warlordstat)){
                                $warlordreducarmorpen = $warlordstat['reduc armor pen'];
                            }
                            if (array_key_exists('armor penetration', $warlordstat)){
                                $warlordarmorpenetration = $warlordstat['armor penetration'];
                            }
                            if (array_key_exists('reduc parred chance', $warlordstat)){
                                $warlordreducparredchance = $warlordstat['reduc parred chance'];
                            }
                            if (array_key_exists('auto attack speed', $warlordstat)){
                                $warlordautoattackspeed = $warlordstat['auto attack speed'];
                            }
                        } 
                    } 
                }
                if ($item->getItems()->getSets()->getName() == 'genesis - ' . $classe){
                    $genesisBonuses = $SetbonusesRepository->findBy(['sets' => $set]);
                    $genesis[] = $item;
                    $genesisnumber = count($genesis);
                    $genesisactivebonuses = array_slice($genesisBonuses, 0, $genesisnumber - 1);
                    if ($genesisactivebonuses !== []) {
                        foreach ($genesisactivebonuses as $key => $bonuses) {
                            $key = $bonuses->getType();
                            $genesisstat[$key] = $bonuses->getValue();
                            if (array_key_exists('intel', $genesisstat)){
                                $genesisintel = $genesisstat['intel'];
                            } 
                            if (array_key_exists('wound', $genesisstat)){
                                $genesiswound = $genesisstat['wound'];
                            } 
                            if (array_key_exists('strenght', $genesisstat)){
                                $genesisstrenght = $genesisstat['strenght'];
                            } 
                            if (array_key_exists('initiative', $genesisstat)){
                                $genesisinitiative = $genesisstat['initiative'];
                            }
                            if (array_key_exists('toughness', $genesisstat)){
                                $genesistoughness= $genesisstat['toughness'];
                            } 
                            if (array_key_exists('willpower', $genesisstat)){
                                $genesiswillpower= $genesisstat['willpower'];
                            } 
                            if (array_key_exists('ballistic skill', $genesisstat)){
                                $genesisballisticskill = $genesisstat['ballistic skill'];
                            } 
                            if (array_key_exists('weapon skill', $genesisstat)){
                                $genesisweaponskill= $genesisstat['weapon skill'];
                            }
                            if (array_key_exists('melee crit chance', $genesisstat)){
                                $genesismeleecritchance = $genesisstat['melee crit chance'];
                            } 
                            if (array_key_exists('ranged crit chance', $genesisstat)){
                                $genesisrangedcritchance = $genesisstat['ranged crit chance'];
                            } 
                            if (array_key_exists('magic crit chance', $genesisstat)){
                                $genesismagiccritchance = $genesisstat['magic crit chance'];
                            } 
                            if (array_key_exists('heal crit chance', $genesisstat)){
                                $genesishealcritchance = $genesisstat['heal crit chance'];
                            } 
                            if (array_key_exists('reduced disrupt', $genesisstat)){
                                $genesisreduceddisruptchance = $genesisstat['reduced disrupt'];
                            } 
                            if (array_key_exists('magic power', $genesisstat)){
                                $genesismagicpower= $genesisstat['magic power'];
                            } 
                            if (array_key_exists('melee power', $genesisstat)){
                                $genesismeleepower= $genesisstat['melee power'];
                            } 
                            if (array_key_exists('ranged power', $genesisstat)){
                                $genesisrangedpower= $genesisstat['ranged power'];
                            } 
                            if (array_key_exists('heal power', $genesisstat)){
                                $genesishealpower= $genesisstat['heal power'];
                            } 
                            if (array_key_exists('armor', $genesisstat)){
                                $genesisarmor = $genesisstat['armor'];
                            } 
                            if (array_key_exists('block', $genesisstat)){
                                $genesisblock = $genesisstat['block'];
                            }
                            if (array_key_exists('parry', $genesisstat)){
                                $genesisparry = $genesisstat['parry'];
                            }
                            if (array_key_exists('dodge', $genesisstat)){
                                $genesisdodge = $genesisstat['dodge'];
                            }
                            if (array_key_exists('disrupt', $genesisstat)){
                                $genesisdisrupt = $genesisstat['disrupt'];
                            }
                            if (array_key_exists('damage', $genesisstat)){
                                $genesisdamage = $genesisstat['damage'];
                            }
                            if (array_key_exists('crit damage', $genesisstat)){
                                $genesiscritdamage = $genesisstat['crit damage'];
                            }
                            if (array_key_exists('reduc critically hit chance', $genesisstat)){
                                $genesisreduccriticallyhitchance = $genesisstat['reduc critically hit chance'];
                            }
                            if (array_key_exists('reduc armor pen', $genesisstat)){
                                $genesisreducarmorpen = $genesisstat['reduc armor pen'];
                            }
                            if (array_key_exists('armor penetration', $genesisstat)){
                                $genesisarmorpenetration = $genesisstat['armor penetration'];
                            }
                            if (array_key_exists('reduc parred chance', $genesisstat)){
                                $genesisreducparredchance = $genesisstat['reduc parred chance'];
                            }
                            if (array_key_exists('auto attack speed', $genesisstat)){
                                $genesisautoattackspeed = $genesisstat['auto attack speed'];
                            }
                        }
                    } 
                }
                
                if ($item->getItems()->getSets()->getName() == 'victorious - ' . $classe){
                    $set = $item->getItems()->getSets();
                    $victoriousBonuses = $SetbonusesRepository->findBy(['sets' => $set]);
                    $victorious[] = $item;
                    $victoriousnumber = count($victorious);
                    $victoriousactivebonuses = array_slice($victoriousBonuses, 0, $victoriousnumber - 1);
                    if ($victoriousactivebonuses !== []) {
                    foreach ($victoriousactivebonuses as $key => $bonuses) {
                        $key = $bonuses->getType();
                        $victoriousstat[$key] = $bonuses->getValue();
                        if (array_key_exists('intel', $victoriousstat)){
                            $victoriousintel = $victoriousstat['intel'];
                        } 
                        if (array_key_exists('wound', $victoriousstat)){
                            $victoriouswound = $victoriousstat['wound'];
                        } 
                        if (array_key_exists('strenght', $victoriousstat)){
                            $victoriousstrenght = $victoriousstat['strenght'];
                        } 
                        if (array_key_exists('initiative', $victoriousstat)){
                            $victoriousinitiative = $victoriousstat['initiative'];
                        }
                        if (array_key_exists('toughness', $victoriousstat)){
                            $victorioustoughness= $victoriousstat['toughness'];
                        } 
                        if (array_key_exists('willpower', $victoriousstat)){
                            $victoriouswillpower= $victoriousstat['willpower'];
                        } 
                        if (array_key_exists('ballistic skill', $victoriousstat)){
                            $victoriousballisticskill = $victoriousstat['ballistic skill'];
                        } 
                        if (array_key_exists('weapon skill', $victoriousstat)){
                            $victoriousweaponskill= $victoriousstat['weapon skill'];
                        }
                        if (array_key_exists('melee crit chance', $victoriousstat)){
                            $victoriousmeleecritchance = $victoriousstat['melee crit chance'];
                        } 
                        if (array_key_exists('ranged crit chance', $victoriousstat)){
                            $victoriousrangedcritchance = $victoriousstat['ranged crit chance'];
                        } 
                        if (array_key_exists('magic crit chance', $victoriousstat)){
                            $victoriousmagiccritchance = $victoriousstat['magic crit chance'];
                        } 
                        if (array_key_exists('heal crit chance', $victoriousstat)){
                            $victorioushealcritchance = $victoriousstat['heal crit chance'];
                        } 
                        if (array_key_exists('reduced disrupt', $victoriousstat)){
                            $victoriousreduceddisruptchance = $victoriousstat['reduced disrupt'];
                        } 
                        if (array_key_exists('magic power', $victoriousstat)){
                            $victoriousmagicpower= $victoriousstat['magic power'];
                        } 
                        if (array_key_exists('melee power', $victoriousstat)){
                            $victoriousmeleepower= $victoriousstat['melee power'];
                        } 
                        if (array_key_exists('ranged power', $victoriousstat)){
                            $victoriousrangedpower= $victoriousstat['ranged power'];
                        } 
                        if (array_key_exists('heal power', $victoriousstat)){
                            $victorioushealpower= $victoriousstat['heal power'];
                        } 
                        if (array_key_exists('armor', $victoriousstat)){
                            $victoriousarmor = $victoriousstat['armor'];
                        } 
                        if (array_key_exists('block', $victoriousstat)){
                            $victoriousblock = $victoriousstat['block'];
                        }
                        if (array_key_exists('parry', $victoriousstat)){
                            $victoriousparry = $victoriousstat['parry'];
                        }
                        if (array_key_exists('dodge', $victoriousstat)){
                            $victoriousdodge = $victoriousstat['dodge'];
                        }
                        if (array_key_exists('disrupt', $victoriousstat)){
                            $victoriousdisrupt = $victoriousstat['disrupt'];
                        }
                        if (array_key_exists('damage', $victoriousstat)){
                            $victoriousdamage = $victoriousstat['damage'];
                        }
                        if (array_key_exists('crit damage', $victoriousstat)){
                            $victoriouscritdamage = $victoriousstat['crit damage'];
                        }
                        if (array_key_exists('reduc critically hit chance', $victoriousstat)){
                            $victoriousreduccriticallyhitchance = $victoriousstat['reduc critically hit chance'];
                        }
                        if (array_key_exists('reduc armor pen', $victoriousstat)){
                            $victoriousreducarmorpen = $victoriousstat['reduc armor pen'];
                        }
                        if (array_key_exists('armor penetration', $victoriousstat)){
                            $victoriousarmorpenetration = $victoriousstat['armor penetration'];
                        }
                        if (array_key_exists('reduc parred chance', $victoriousstat)){
                            $victoriousreducparredchance = $victoriousstat['reduc parred chance'];
                        }
                        if (array_key_exists('auto attack speed', $victoriousstat)){
                            $victoriousautoattackspeed = $victoriousstat['auto attack speed'];
                        }
                    } 
                } 
            }
                if ($item->getItems()->getSets()->getName() == 'nehekharan - ' . $classe){
                    $set = $item->getItems()->getSets();
                    $snehekharanBonuses = $SetbonusesRepository->findBy(['sets' => $set]);
                    $nehekharan[] = $item;
                    $nehekharannumber = count($nehekharan);
                    $nehekharanactivebonuses = array_slice($snehekharanBonuses, 0, $nehekharannumber - 1);
                    if ($nehekharanactivebonuses !== []) {
                    foreach ($nehekharanactivebonuses as $key => $bonuses) {
                        $key = $bonuses->getType();
                        $nehekharanstat[$key] = $bonuses->getValue();
                        if (array_key_exists('intel', $nehekharanstat)){
                            $nehekharanintel = $nehekharanstat['intel'];
                        } 
                        if (array_key_exists('wound', $nehekharanstat)){
                            $nehekharanwound = $nehekharanstat['wound'];
                        } 
                        if (array_key_exists('strenght', $nehekharanstat)){
                            $nehekharanstrenght = $nehekharanstat['strenght'];
                        } 
                        if (array_key_exists('initiative', $nehekharanstat)){
                            $nehekharaninitiative = $nehekharanstat['initiative'];
                        }
                        if (array_key_exists('toughness', $nehekharanstat)){
                            $nehekharantoughness= $nehekharanstat['toughness'];
                        } 
                        if (array_key_exists('willpower', $nehekharanstat)){
                            $nehekharanwillpower= $nehekharanstat['willpower'];
                        } 
                        if (array_key_exists('ballistic skill', $nehekharanstat)){
                            $nehekharanballisticskill = $nehekharanstat['ballistic skill'];
                        } 
                        if (array_key_exists('weapon skill', $nehekharanstat)){
                            $nehekharanweaponskill= $nehekharanstat['weapon skill'];
                        }
                        if (array_key_exists('melee crit chance', $nehekharanstat)){
                            $nehekharanmeleecritchance = $nehekharanstat['melee crit chance'];
                        } 
                        if (array_key_exists('ranged crit chance', $nehekharanstat)){
                            $nehekharanrangedcritchance = $nehekharanstat['ranged crit chance'];
                        } 
                        if (array_key_exists('magic crit chance', $nehekharanstat)){
                            $nehekharanmagiccritchance = $nehekharanstat['magic crit chance'];
                        } 
                        if (array_key_exists('heal crit chance', $nehekharanstat)){
                            $nehekharanhealcritchance = $nehekharanstat['heal crit chance'];
                        } 
                        if (array_key_exists('reduced disrupt', $nehekharanstat)){
                            $nehekharanreduceddisruptchance = $nehekharanstat['reduced disrupt'];
                        } 
                        if (array_key_exists('magic power', $nehekharanstat)){
                            $nehekharanmagicpower= $nehekharanstat['magic power'];
                        } 
                        if (array_key_exists('melee power', $nehekharanstat)){
                            $nehekharanmeleepower= $nehekharanstat['melee power'];
                        } 
                        if (array_key_exists('ranged power', $nehekharanstat)){
                            $nehekharanrangedpower= $nehekharanstat['ranged power'];
                        } 
                        if (array_key_exists('heal power', $nehekharanstat)){
                            $nehekharanhealpower= $nehekharanstat['heal power'];
                        } 
                        if (array_key_exists('armor', $nehekharanstat)){
                            $nehekharanarmor = $nehekharanstat['armor'];
                        } 
                        if (array_key_exists('block', $nehekharanstat)){
                            $nehekharanblock = $nehekharanstat['block'];
                        }
                        if (array_key_exists('parry', $nehekharanstat)){
                            $nehekharanparry = $nehekharanstat['parry'];
                        }
                        if (array_key_exists('dodge', $nehekharanstat)){
                            $nehekharandodge = $nehekharanstat['dodge'];
                        }
                        if (array_key_exists('disrupt', $nehekharanstat)){
                            $nehekharandisrupt = $nehekharanstat['disrupt'];
                        }
                        if (array_key_exists('damage', $nehekharanstat)){
                            $nehekharandamage = $nehekharanstat['damage'];
                        }
                        if (array_key_exists('crit damage', $nehekharanstat)){
                            $nehekharancritdamage = $nehekharanstat['crit damage'];
                        }
                        if (array_key_exists('reduc critically hit chance', $nehekharanstat)){
                            $nehekharanreduccriticallyhitchance = $nehekharanstat['reduc critically hit chance'];
                        }
                        if (array_key_exists('reduc armor pen', $nehekharanstat)){
                            $nehekharanreducarmorpen = $nehekharanstat['reduc armor pen'];
                        }
                        if (array_key_exists('armor penetration', $nehekharanstat)){
                            $nehekharanarmorpenetration = $nehekharanstat['armor penetration'];
                        }
                        if (array_key_exists('reduc parred chance', $nehekharanstat)){
                            $nehekharanreducparredchance = $nehekharanstat['reduc parred chance'];
                        }
                        if (array_key_exists('auto attack speed', $nehekharanstat)){
                            $nehekharanautoattackspeed = $nehekharanstat['auto attack speed'];
                        }
                        } 
                    } 
                }
            }
        } 
        
        $TotalSetBonusintel = $sovereignintel + $warlordintel + $genesisintel + $victoriousintel + $nehekharanintel;
        $TotalSetBonuswound = $sovereignwound + $warlordwound + $genesiswound + $victoriouswound + $nehekharanwound;
        $TotalSetBonusstrenght = $sovereignstrenght + $warlordstrenght + $genesisstrenght+ $nehekharanstrenght;                      
        $TotalSetBonusinitiative = $sovereigninitiative + $warlordinitiative+ $genesisinitiative + $nehekharaninitiative;
        $TotalSetBonustoughness = $sovereigntoughness + $warlordtoughness + $genesistoughness + $nehekharantoughness;
        $TotalSetBonuswillpower = $sovereignwillpower + $warlordwillpower + $genesiswillpower + $nehekharanwillpower;
        $TotalSetBonusballisticskill = $sovereignballisticskill + $warlordballisticskill + $genesisballisticskill + $nehekharanballisticskill;
        $TotalSetBonusweaponskill = $sovereignweaponskill + $warlordweaponskill + $genesisweaponskill+ $nehekharanweaponskill;
        $TotalSetBonusmeleecritchance = $sovereignmeleecritchance + $warlordmeleecritchance + $genesismeleecritchance + $nehekharanmeleecritchance;
        $TotalSetBonusrangedcritchance = $sovereignrangedcritchance + $warlordrangedcritchance + $genesisrangedcritchance + $nehekharanrangedcritchance;
        $TotalSetBonusmagiccritchance = $sovereignmagiccritchance + $warlordmagiccritchance + $genesismagiccritchance + $nehekharanmagiccritchance;
        $TotalSetBonushealcritchance = $sovereignhealcritchance + $warlordhealcritchance + $genesishealcritchance + $nehekharanhealcritchance;
        $TotalSetBonusreduceddisruptchance = $sovereignreduceddisruptchance + $warlordreduceddisruptchance + $genesisreduceddisruptchance + $nehekharanreduceddisruptchance;
        $TotalSetBonusmagicpower = $sovereignmagicpower + $warlordmagicpower + $genesismagicpower + $nehekharanmagicpower;
        $TotalSetBonusmeleepower = $sovereignmeleepower + $warlordmeleepower + $genesismeleepower + $nehekharanmeleepower;
        $TotalSetBonusrangedpower = $sovereignrangedpower + $warlordrangedpower + $genesisrangedpower + $nehekharanrangedpower;
        $TotalSetBonushealpower = $sovereignhealpower + $warlordhealpower + $genesishealpower + $nehekharanhealpower;
        $TotalSetBonusarmor = $sovereignarmor + $warlordarmor + $genesisarmor + $nehekharanarmor;
        $TotalSetBonusblock = $sovereignblock + $warlordblock + $genesisblock + $nehekharanblock;
        $TotalSetBonusparry = $sovereignparry + $warlordparry + $genesisparry + $nehekharanparry;
        $TotalSetBonusdodge = $sovereigndodge + $warlorddodge + $genesisdodge + $nehekharandodge;
        $TotalSetBonusdisrupt = $sovereigndisrupt + $warlorddisrupt + $genesisdisrupt + $nehekharandisrupt;
        $TotalSetBonusdamage = $sovereigndamage + $warlorddamage + $genesisdamage + $nehekharandamage;
        $TotalSetBonuscritdamage = $sovereigncritdamage + $warlordcritdamage + $genesiscritdamage + $nehekharancritdamage;
        $TotalSetBonusreduccriticallyhitchance = $sovereignreduccriticallyhitchance + $warlordreduccriticallyhitchance + $genesisreduccriticallyhitchance + $nehekharanreduccriticallyhitchance;
        $TotalSetBonusreducarmorpen = $sovereignreducarmorpen + $warlordreducarmorpen + $genesisreducarmorpen + $nehekharanreducarmorpen;
        $TotalSetBonusarmorpenetration = $sovereignarmorpenetration+ $warlordarmorpenetration + $genesisarmorpenetration + $nehekharanarmorpenetration;
        $TotalSetBonusreducparredchance = $sovereignreducparredchance + $warlordreducparredchance + $genesisreducparredchance + $nehekharanreducparredchance;
        $TotalSetBonusautoattackspeed = $sovereignautoattackspeed + $warlordautoattackspeed + $genesisautoattackspeed + $nehekharanautoattackspeed;
        /* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! */

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
        $totalMeleepower = "0";
        $totalMagicpower = "0";
        $totalRangedpower = "0";
        $totalHealpower = "0";
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
        $totalMeleepower += $items->getItems()->getMeleepower();
        $totalRangedpower += $items->getItems()->getRangedpower();
        $totalHealpower += $items->getItems()->getHealpower();
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
                if ($renown->getRenownabilities()->getType() == ("magic crit")) {
                    $magiccrit += $renown->getRenownabilities()->getValue();
                }
                if ($renown->getRenownabilities()->getType() == ("melee crit")) {
                    $meleecrit += $renown->getRenownabilities()->getValue();
                }
                if ($renown->getRenownabilities()->getType() == ("ranged crit")) {
                    $rangedcrit += $renown->getRenownabilities()->getValue();
                }
                if ($renown->getRenownabilities()->getType() == ("heal crit")) {
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
            'templateclass' => $templateclass,
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
            'DisruptfromRenownWill'=> $DisruptFromRenownWill,
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
            'ap' => $totalAP,
            'critheal' => $totalCritheal,
            'healpower' => $totalHealpower,
            'magicpower' => $totalMagicpower,
            'meleepower' => $totalMeleepower,
            'rangedpower' => $totalRangedpower,
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
            'DisruptFromTalismansWill' => $DisruptFromTalismansWill,
            'talismansweaponskill' => $Talismansweaponskill, 
            'ParryFromTalismansWeaponskill' => $ParryFromTalismansWeaponskill,
            'talismansballisticskill' => $Talismansballisticskill,
            'talismansarmor' => $Talismansarmor,

            /* Bonus set stats */
            'TotalSetBonusIntel' => $TotalSetBonusintel,
            'TotalSetBonusWound' => $TotalSetBonuswound, 
            'TotalSetBonusStrenght' => $TotalSetBonusstrenght,                      
            'TotalSetBonusInitiative' => $TotalSetBonusinitiative, 
            'TotalSetBonusToughness' => $TotalSetBonustoughness, 
            'TotalSetBonusWillpower' => $TotalSetBonuswillpower, 
            'TotalSetBonusBallisticskill' => $TotalSetBonusballisticskill,
            'TotalSetBonusWeaponskill' => $TotalSetBonusweaponskill,
            'TotalSetBonusMeleecritchance' => $TotalSetBonusmeleecritchance,
            'TotalSetBonusRangedcritchance' => $TotalSetBonusrangedcritchance,
            'TotalSetBonusMagiccritchance' => $TotalSetBonusmagiccritchance,
            'TotalSetBonusHealcritchance' => $TotalSetBonushealcritchance,
            'TotalSetBonusReduceddisruptchance' => $TotalSetBonusreduceddisruptchance,
            'TotalSetBonusMagicpower' => $TotalSetBonusmagicpower,
            'TotalSetBonusMeleepower' => $TotalSetBonusmeleepower,
            'TotalSetBonusRangedpower' => $TotalSetBonusrangedpower,
            'TotalSetBonusHealpower' => $TotalSetBonushealpower,
            'TotalSetBonusArmor' => $TotalSetBonusarmor,
            'TotalSetBonusBlock' => $TotalSetBonusblock,
            'TotalSetBonusParry' => $TotalSetBonusparry,
            'TotalSetBonusDodge' => $TotalSetBonusdodge,
            'TotalSetBonusDisrupt' => $TotalSetBonusdisrupt,
            'TotalSetBonusDamage' => $TotalSetBonusdamage,
            'TotalSetBonusCritdamage' => $TotalSetBonuscritdamage,
            'TotalSetBonusReducedcriticallyhitchance' => $TotalSetBonusreduccriticallyhitchance,
            'TotalSetBonusReducedarmorpenetration' => $TotalSetBonusreducarmorpen,
            'TotalSetBonusArmorpenetration' => $TotalSetBonusarmorpenetration,
            'TotalSetBonusReducedparredchance' => $TotalSetBonusreducparredchance,
            'TotalSetBonusAutoattackspeed' => $TotalSetBonusautoattackspeed  
        ]);
    }
}