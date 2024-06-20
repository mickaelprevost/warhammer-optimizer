<?php

namespace App\Controller;

use App\Repository\ClasseRepository;
use App\Repository\FactionRepository;
use App\Repository\ItemsRepository;
use App\Repository\ItemstypeRepository;
use App\Repository\SetbonusesRepository;
use App\Repository\SetsRepository;
use App\Repository\TemplateRepository;
use App\Repository\TemplateListeRepository;
use App\Entity\Items;
use App\Entity\Template;
use App\Entity\TemplateListe;
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

    #[Route('/classe/{id<\d+>}', name: 'app_classe')]
    public function classe($id, ItemsRepository $itemsRepository, ItemstypeRepository $itemstypeRepository, 
    ClasseRepository $classeRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $gear = $itemsRepository->findBy(['classe' => $id]);
        $classe = $classeRepository->findOneBy(['id' => $id]);
        $classeId = $classe->getId();
        $types = $itemstypeRepository->findAll();
        $liste = [];
        
        foreach ($types as $id => $type){
            $id = $type->getId();
            $liste[$id] = $itemsRepository->findBy(['type' => $id]);
        }

        $Liste = [];
        if ($request->getMethod() === 'POST') {

            $template = new Template();

            $all = $request->request->All();
            foreach ($all as $item) {
                $Liste = $itemsRepository->findBy(['name' => $item]);
                $Nom = $request->request->get('nom');
            } 

            $template->setNom($Nom);
            $entityManager->persist($template);

            foreach ($Liste as $liste) {
                $TemplateListe = new TemplateListe();
                $TemplateListe->setItems($liste);
                $TemplateListe->setTemplate($template);
                $entityManager->persist($TemplateListe);
            }
            $entityManager->flush();
            return $this->redirectToRoute('app_template', ['id' => $template->getId()]);
        }
         
        return $this->render('classe.html.twig', [
            'classe' => $classe,
            'classeId' => $classeId,
            'gear' => $liste,
            'types' => $types
        ]);
    }

    #[Route('/template/{id<\d+>}', name: 'app_template')]
    public function template($id, TemplateRepository $templateRepository, TemplateListeRepository $templateListeRepository,
    ItemsRepository $itemsRepository): Response
    {
        $name = $templateRepository->findOneBy(['id' => $id]);
        $liste = $templateListeRepository->findBy(['template' => $id]);
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
        $totalCritheal = "0";
        $totalMagicpower = "0";
        $totalWisdom = "0";
        $totalWeaponskill= "0";
        $totalMagiccritchance = "0";
        $totalDodge = "0";
        $totalDisrupt = "0";
        
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
            $totalWisdom += $items->getItems()->getWisdom(); 
            $totalWound += $items->getItems()->getWound();          
        }
        return $this->render('template.html.twig', [
            'liste' => $object,
            'name' => $name,
            'armor' => $totalArmor,
            'disrupt' => $totalDisrupt,
            'dodge' => $totalDodge,
            'resist' => $totalResist,
            'magicpower' => $totalMagicpower,
            'ap' => $totalAP,
            'critheal' => $totalCritheal,
            'meleecritchance' => $totalMeleecritchance,
            'magiccritchance' => $totalMagiccritchance,
            'intel' => $totalIntel,
            'wound' => $totalWound,
            'initiative' => $totalInitiative,
            'toughness' => $totalToughness,
            'strenght' => $totalStrenght,
            'wisdom' => $totalWisdom,
            'weaponskill' => $totalWeaponskill
        ]);
    }
}
