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

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil', methods: ['GET'])]
    public function index(RecetteRepository $recetteRepository, Request $request): Response
    {
        //recuperer les produits liées à une recherche dans la bar de recherche
        $searchData= new SearchData();
        $formSearch = $this-> createForm(SearchType::class, $searchData);

        //doit chercher la reponse
        $formSearch->handleRequest($request);
        if($formSearch->isSubmitted() && $formSearch->isValid()) {
           $searchData->page=$request->query->getInt('page', 1);
           $recettes=$recetteRepository->findBySearch($searchData);

           return $this-> render('page/accueil.html.twig', [
            'formSearch' => $formSearch,
            'recettes' =>$recettes,
           ]);

        }


        return $this->render('page/accueil.html.twig', [
            'formSearch'=>$formSearch->createView(),
            //'recettes' => $recetteRepository->findBy(
                //[],
                //['id' => 'DESC'],
                //10

            //),
            
        ]);
    }
    #[Route('/conditions-generales', name: 'app_conditions_generales', methods: ['GET'])]
    public function conditions_generale(): Response
    {
        return $this->render('page/conditions-generales.html.twig');
    }

    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function contact(Request $request): Response
    {
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
        ]);
    }
    #[Route('/navbarmobil', name: 'app_navbarmobil', methods: ['GET'])]
    public function navbar_mobil(): Response
    {
        return $this->render('page/navbarmobil.html.twig');
    }
}
