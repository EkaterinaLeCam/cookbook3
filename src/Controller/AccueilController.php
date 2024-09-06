<?php

namespace App\Controller;


use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ContactType;
use App\Form\SearchType;
use App\Model\SearchData;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;



class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil', methods: ['GET'])]
    public function index(RecetteRepository $recetteRepository, Request $request): Response
    {
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
        } else {
            // Si aucune recherche n'est faite, récupérer toutes les recettes
            $recettes = $recetteRepository->findAll();
        }

        // Rendre la vue avec les recettes et le formulaire de recherche
        return $this->render('page/accueil.html.twig', [
            'recettes' => $recettes,
            'formSearch' => $formSearch->createView(),
        ]);
    }



    #[Route('/conditions-generales', name: 'app_conditions_generales', methods: ['GET'])]
    public function conditions_generale(RecetteRepository $recetteRepository, Request $request): Response
    {

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

        // Si aucune recherche n'est faite, récupérer toutes les recettes
        $recettes = $recetteRepository->findAll();

        return $this->render('page/conditions-generales.html.twig', [
            'recettes' => $recettes,
            'formSearch' => $formSearch->createView(),
        ]);
    }

    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function contact(RecetteRepository $recetteRepository, Request $request): Response
    {
        //Barre de recherche
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
        //Contact
        // Importation du formulaire
        $form = $this->createForm(ContactType::class);

        // Saisir les données du formulaire
        $form->handleRequest($request);

        // Si le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) {


            // Traitement de l'upload
            $file = $form->get('curriculum')->getData();
            if ($form->get('curriculum')->getData()) {
                $cvFile = $form->get('curriculum')->getData();
                $originalFilename = pathinfo($cvFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $cvFile->guessExtension();

                try {
                    $cvFile->move(
                        $this->getParameter('uploads'),
                        $newFilename
                    );
                    $this->addFlash('success', 'Votre CV a bien été envoyé');
                    return $this->redirectToRoute('app_contact');
                } catch (FileException $e) {
                    $this->addFlash('danger', 'Une erreur est survenue lors de l\'upload de votre CV');
                }
            }
        }

        return $this->render('page/contact.html.twig', [
            'contactForm' => $form, // Transfert du formulaire au template
            'recettes' => $recettes,
            'formSearch' => $formSearch->createView(),
        ]);
    }
    #[Route('/navbarmobil', name: 'app_navbarmobil', methods: ['GET'])]
    public function navbar_mobil(): Response
    {
        return $this->render('page/navbarmobil.html.twig');
    }
}
