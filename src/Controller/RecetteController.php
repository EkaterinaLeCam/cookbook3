<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecetteController extends AbstractController
{
    #[Route('/recettes', name: 'app_recette', methods:['GET'])]
    public function index(RecetteRepository $recetteRepository): Response
    {
        return $this->render('recette/index.html.twig', [
            'recettes' => $recetteRepository->findBy(
                [],
                ['nom'=>'ASC']
            ),
        ]);
    }
    #[Route('/recettes{id}', name: 'app_recette_one', methods:['GET'])]
    public function recette(Recette $recette): Response
    {
        return $this->render('recette/recette_one.html.twig', [
            'recette' => $recette,
        ]);
    }
}
