<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\RecetteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecetteController extends AbstractController
{
    // Afficher la liste des recettes
    #[Route('/recettes', name: 'app_recette', methods: ['GET'])]
    public function index(
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

        return $this->render('recette/index.html.twig', [
            'recetteRepository' => $recetteRepository,
            'formSearch' => $formSearch->createView(),
            'recettes' => $recettes,
        ]);
    }

    // Afficher une recette
    #[Route('/recette/{slug}', name: 'app_recette_one', methods: ['GET', 'POST'])]
    public function recette(
        RecetteRepository $recette,
        RecetteRepository $recetteRepository,
        Request $request,
        string $slug
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
        }

        $selection = $recette->findOneBy(['slug' => $slug])->getNotes();
        $notes = [];
        foreach ($selection as  $value) {
            array_push($notes, $value->getEtoile());
        }

        return $this->render('recette/recette_one.html.twig', [
            'recette' => $recette->findOneBy(['slug' => $slug]),
            'notes' => array_count_values($notes),
            'recettes' => $recettes,
            'formSearch' => $formSearch->createView(),
        ]);
    }
}
