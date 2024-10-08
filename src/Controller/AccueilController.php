<?php

namespace App\Controller;


use App\Repository\RecetteRepository;
use Knp\Component\Pager\PaginatorInterface;
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
    public function index(
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

        // Créer une instance de QueryBuilder pour la pagination
        $queryBuilder = $recetteRepository->createQueryBuilder('r');

        // Vérifiez si le formulaire est soumis et valide
        if ($formSearch->isSubmitted() && $formSearch->isValid()) {
            // Récupérer la valeur de recherche
            $query = $searchData->getQ();

            // Ajouter des conditions de recherche à la requête
            $queryBuilder
                ->where('r.nom LIKE :query')
                ->setParameter('query', '%' . $query . '%');
        }

        // Pagination
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            4 /* limit par page */
        );

        return $this->render('page/accueil.html.twig', [
            'recettes' => $pagination,
            'formSearch' => $formSearch->createView(),
        ]);
    }



    #[Route('/conditions-generales', name: 'app_conditions_generales', methods: ['GET'])]
    public function conditions_generale(RecetteRepository $recetteRepository, Request $request, PaginatorInterface $paginator): Response
    {

        //Barre de recherche
        // Créer une instance de SearchData pour capturer les données du formulaire
        $searchData = new SearchData();

        // Créer le formulaire de recherche en utilisant le type de formulaire SearchType
        $formSearch = $this->createForm(SearchType::class, $searchData);

        // Gérer la requête pour extraire les données du formulaire
        $formSearch->handleRequest($request);

        // Créer une instance de QueryBuilder pour la pagination
        $queryBuilder = $recetteRepository->createQueryBuilder('r');

        // Vérifiez si le formulaire est soumis et valide
        if ($formSearch->isSubmitted() && $formSearch->isValid()) {
            // Récupérer la valeur de recherche
            $query = $searchData->getQ();

            // Ajouter des conditions de recherche à la requête
            $queryBuilder
                ->where('r.nom LIKE :query')
                ->setParameter('query', '%' . $query . '%');

            // Pagination
            $pagination = $paginator->paginate(
                $queryBuilder, /* query NOT result */
                $request->query->getInt('page', 1), /* page number */
                10 /* limit per page */
            );
            // Rendre la vue avec les recettes et le formulaire de recherche
            return $this->render('page/accueil.html.twig', [
                'recettes' => $pagination,
                'formSearch' => $formSearch->createView(),
            ]);
        } else {

   

        return $this->render('page/conditions-generales.html.twig', [
           
            'formSearch' => $formSearch->createView(),
        ]);
    }}

    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function contact(RecetteRepository $recetteRepository, Request $request, ): Response
    {
{
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
                        $this->addFlash('success', 'Votre pièce jointe a bien été envoyée');
                        return $this->redirectToRoute('app_contact');
                    } catch (FileException $e) {
                        $this->addFlash('danger', 'Une erreur est survenue lors de l\'upload de votre pièce jointe');
                    }
                }
            }

            return $this->render('page/contact.html.twig', [
                'contactForm' => $form, // Transfert du formulaire au template
           
                
            ]);
        }
    }
    #[Route('/navbarmobil', name: 'app_navbarmobil', methods: ['GET'])]
    public function navbar_mobil(): Response
    {
        return $this->render('page/navbarmobil.html.twig');
    }
}
