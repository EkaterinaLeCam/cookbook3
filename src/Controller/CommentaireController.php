<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\CommentaireRepository;
use App\Repository\RecetteRepository;
use App\Service\ModerationService;
use Doctrine\ORM\EntityManagerInterface;
use Egulias\EmailValidator\Parser\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentaireController extends AbstractController
{
    #[Route('/commentaires', name: 'app_commentaire', methods: ['GET'])]
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaireRepository->findBy(
                [],
                ['nom' => 'DESC']
            ),
        ]);
    }

    #[Route('/commentaires/{id}', name: 'app_recette_commentaire_new', methods: ['GET', 'POST'])]
    public function nouveauCommentaire(
      
        RecetteRepository $recetteRepository,
        EntityManagerInterface $em,
        Request $request,
        ModerationService $moderationService,
    ): Response {
        // Barre de recherche
        $searchData = new SearchData();
        $formSearch = $this->createForm(SearchType::class, $searchData);
        $formSearch->handleRequest($request);

        // Gestion de la recherche
        if ($formSearch->isSubmitted() && $formSearch->isValid()) {
            $recettes = $recetteRepository->findByQuery($searchData->getQ());
            return $this->render('page/accueil.html.twig', [
                'recettes' => $recettes,
                'formSearch' => $formSearch->createView(),
            ]);
        }

        // Récupération de la recette par ID
        $recette = $recetteRepository->find($request->get('id'));
        if (!$recette) {
            throw $this->createNotFoundException('Recette non trouvée');
        }

        // Formulaire de commentaire
        $form = $this->createForm(CommentaireType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contenu = $form->get('contenu')->getData();
            $isApproved = $moderationService->checkComment($contenu);

            $commentaire = new Commentaire();
            $commentaire
                ->setContenu($contenu)
                ->setRecette($recette)
                ->setAuteur($this->getUser())
                ->setStatut($isApproved);

            $em->persist($commentaire);
            $em->flush();
            // Ajouter un flash message de succès
            $this->addFlash('success', 'Votre commentaire a été ajoutée avec succès !');

            return $this->redirectToRoute('app_recette_one', [
                'slug' => $recette->getSlug(),
            ]);
        }

        return $this->render('commentaire/new.html.twig', [
            'form' => $form->createView(),
            'recette' => $recette,
            'formSearch' => $formSearch->createView(),
        ]);
    }


}
