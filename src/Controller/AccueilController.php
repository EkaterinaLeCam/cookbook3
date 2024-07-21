<?php

namespace App\Controller;

use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil', methods:['GET'])]
    public function index(RecetteRepository $recetteRepository): Response
    {
        return $this->render('accueil/accueil.html.twig', [
            'recettes' => $recetteRepository->findBy(
                [],
                ['id'=>'DESC'],10
             
            ),
        ]);
    }
}
