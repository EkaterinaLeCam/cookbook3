<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategorieController extends AbstractController
{
    #[Route('/categories', name: 'app_categorie', methods:['GET'])]
    public function index(
        CategorieRepository $categorieRepository
    ): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepository->findBy(
                [],
                ['nom' => 'ASC']
            ),
        ]);
    }

    #[Route('/categories/{id}', name: 'app_categorie_show', methods:['GET'])]
    public function show(
        Categorie $categorie,
    ): Response
    {
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }
}
