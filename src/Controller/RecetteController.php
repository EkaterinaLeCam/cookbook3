<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Repository\RecetteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecetteController extends AbstractController
{
    // Afficher la liste des recettes
    #[Route('/recettes', name: 'app_recette', methods:['GET'])]
    public function index(
        RecetteRepository $recetteRepository, 
        
        Request $request
        ): Response
    {
      
        
        return $this->render('recette/index.html.twig', [
            'recettes' => $recetteRepository->findBy([],['nom'=>'ASC'],10),
        ]);
    }

    // Afficher une recette
    #[Route('/recette/{slug}', name: 'app_recette_one', methods:['GET', 'POST'])]
    public function recette(
        RecetteRepository $recette,
        string $slug
        ): Response
    {
        $selection = $recette->findOneBy(['slug' => $slug])->getNotes();
        $notes = [];
        foreach ($selection as  $value) {
            array_push($notes, $value->getEtoile());
        }
    
        return $this->render('recette/recette_one.html.twig', [
            'recette' => $recette->findOneBy(['slug' => $slug]),
            'notes' => array_count_values($notes),
        ]);
    }
}
