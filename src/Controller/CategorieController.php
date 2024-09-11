<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\CategorieRepository;
use App\Repository\RecetteRepository;
use Knp\Component\Pager\PaginatorInterface;
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
        Request $request,
        PaginatorInterface $paginator
    ): Response {
        // Créer une instance de SearchData pour capturer les données du formulaire
        $searchData = new SearchData();

        // Créer le formulaire de recherche en utilisant le type de formulaire SearchType
        $formSearch = $this->createForm(SearchType::class, $searchData);

        // Gérer la requête pour extraire les données du formulaire
        $formSearch->handleRequest($request);

        // Créer une instance de QueryBuilder pour les recettes
        $queryBuilder = $recetteRepository->createQueryBuilder('r');

        // Vérifiez si le formulaire est soumis et valide
        if ($formSearch->isSubmitted() && $formSearch->isValid()) {
            // Ajouter des conditions de recherche à la requête
            $queryBuilder
                ->where('r.nom LIKE :query')
                ->setParameter('query', '%' . $searchData->getQ() . '%');
        }

        // Pagination
        $pagination = $paginator->paginate(
            $queryBuilder->getQuery(), // On exécute la requête ici
            $request->query->getInt('page', 1), // Page number
            10 // Limit per page
        );

        // Rendre la vue avec les catégories, les recettes paginées et le formulaire de recherche
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepository->findBy(
                [],
                ['nom' => 'ASC']
            ),
            'recettes' => $pagination,
            'formSearch' => $formSearch->createView(),
        ]);
    }

    #[Route('/categories/{id}', name: 'app_categorie_show', methods: ['GET'])]
    public function show(
        Categorie $categorie,
        RecetteRepository $recetteRepository,
        Request $request, PaginatorInterface $paginator
    ): Response {
        // Créer une instance de SearchData pour capturer les données du formulaire
        $searchData = new SearchData();

        // Créer le formulaire de recherche en utilisant le type de formulaire SearchType
        $formSearch = $this->createForm(SearchType::class, $searchData);

        // Gérer la requête pour extraire les données du formulaire
        $formSearch->handleRequest($request);

        // Créer une instance de QueryBuilder pour récupérer les recettes associées à la catégorie
        $queryBuilder = $recetteRepository->createQueryBuilder('r')
            ->where('r.categorie = :categorie')
            ->setParameter('categorie', $categorie);

        // Vérifiez si le formulaire est soumis et valide
        if ($formSearch->isSubmitted() && $formSearch->isValid()) {
            // Récupérer la valeur de recherche
            $query = $searchData->getQ();

            // Ajouter des conditions de recherche à la requête
            $queryBuilder
                ->andWhere('r.nom LIKE :query')
                ->setParameter('query', '%' . $query . '%');
        }
        // Pagination
            $pagination = $paginator->paginate(
            $queryBuilder->getQuery(), // On exécute la requête ici
            $request->query->getInt('page', 1), // Page number
            10 // Limit per page
        );

  

        // Rendre la vue avec les recettes et le formulaire de recherche
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
            'recettes' => $pagination,
            'formSearch' => $formSearch->createView(),
        ]);
    }
}
