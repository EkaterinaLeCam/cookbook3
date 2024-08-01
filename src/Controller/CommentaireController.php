<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Egulias\EmailValidator\Parser\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentaireController extends AbstractController
{
    #[Route('/commentaires', name: 'app_commentaire', methods:['GET'])]
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaireRepository->findBy(
                [],
                ['nom'=>'DESC']
            ),
        ]);
    }

    #[Route('/commentaire/{id}', name: 'app_recette_commentaire_new', methods:['GET', 'POST'])]
    public function nouveauCommentaire(
        Commentaire $commentaire,
        RecetteRepository $recetteRepository,
        EntityManagerInterface $em,
        Request $request,
        ): Response {
            $recette = $recetteRepository->findOneBy(['id' => $request->get('id')]);
            $form = $this->createForm(CommentaireType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // $ai = ModerationService::check($form->get('contenu')->getData());
                $commentaire = new Commentaire();
                $commentaire
                    ->setContenu($form->get('contenu')->getData())
                    ->setRecette($recette)
                    ->setAuteur($this->getUser())
                ;

                // if ($ai = true) {
                //     $commentaire->setStatut(true);
                // }

                $em->persist($commentaire);
                $em->flush();

                return $this->redirectToRoute('app_recette_one', ['slug' => $recette->getSlug()]);
            }

            return $this->render('commentaire/new.html.twig', [
                'form' => $form,
                'recette' => $recette
            ]);
    }


    // #[Route('/commentaires{id}', name: 'app_commentaire_one', methods:['GET', 'POST'])]
    // public function commentaire_one(Commentaire $commentaire): Response
    // {
    //     return $this->render('commentaire/commentaire_one.html.twig', [
    //         'commentaire' => $commentaire,
    //     ]);
    // }
}
