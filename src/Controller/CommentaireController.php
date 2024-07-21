<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    #[Route('/commentaires{id}', name: 'app_commentaire_one', methods:['GET', 'POST'])]
    public function commentaire_one(Commentaire $commentaire): Response
    {
        return $this->render('commentaire/commentaire_one.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }
}
