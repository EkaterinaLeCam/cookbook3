<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\CategorieRepository;
use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategorieController extends AbstractController
{
    #[Route('/categories', name: 'app_categorie', methods: ['GET'])]
    public function index(
        CategorieRepository $categorieRepository,
        RecetteRepository $recetteRepository,
        Request $request
    ): Response {
        // Créer une instance de SearchData pour capturer les données du formulaire
        $searchData = new SearchData();

        // Créer le formulaire de recherche en utilisant le type de formulaire SearchType
        $formSearch = $this->createForm(SearchType::class, $searchData);

        // Gérer la requête pour extraire les données du formulaire
        $formSearch->handleRequest($request);

        // Initialiser les résultats des recettes
        $recettes = [];

        // Vérifiez si le formulaire est soumis et valide
        if ($formSearch->isSubmitted() && $formSearch->isValid()) {
            // Récupérer la valeur de recherche
            $query = $searchData->getQ();

            // Utiliser la méthode findByQuery du repository pour rechercher les recettes
            $recettes = $recetteRepository->findByQuery($query);

            // Rendre la vue avec les recettes et le formulaire de recherche
            return $this->render('page/accueil.html.twig', [
                'recettes' => $recettes,
                'formSearch' => $formSearch->createView(),
            ]);
        } else {
            // Si aucune recherche n'est faite, récupérer toutes les recettes
            $recettes = $recetteRepository->findAll();
        }
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepository->findBy(
                [],
                ['nom' => 'ASC']
            ),
            'recettes' => $recettes,
            'formSearch' => $formSearch->createView(),
        ]);
    }

    #[Route('/categories/{id}', name: 'app_categorie_show', methods: ['GET'])]
    public function show(
        Categorie $categorie,
        RecetteRepository $recetteRepository,
        Request $request
    ): Response {
        // Créer une instance de SearchData pour capturer les données du formulaire
        $searchData = new SearchData();

        // Créer le formulaire de recherche en utilisant le type de formulaire SearchType
        $formSearch = $this->createForm(SearchType::class, $searchData);

        // Gérer la requête pour extraire les données du formulaire
        $formSearch->handleRequest($request);

        // Initialiser les recettes à null et les charger conditionnellement
        $recettes = $formSearch->isSubmitted() && $formSearch->isValid()
            ? $recetteRepository->findByQuery($searchData->getQ())
            : $recetteRepository->findAll();

        // Rendre la vue avec les recettes et le formulaire de recherche
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
            'recettes' => $recettes,
            'formSearch' => $formSearch->createView(),
        ]);
    }
}
