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
        return $this->render('page/accueil.html.twig', [
            'recettes' => $recetteRepository->findBy(
                [],
                ['id'=>'DESC'],10
             
            ),
        ]);
    }
    #[Route('/conditions-generales', name: 'app_conditions_generales', methods:['GET'])]
    public function conditions_generale(): Response
    {
        return $this->render('page/conditions-generales.html.twig' );
       
    }
    #[Route('/contact', name: 'app_contact', methods:['GET', 'POST'])]
    public function contact(): Response
    {
        return $this->render('page/contact.html.twig' );
       
    }
}
