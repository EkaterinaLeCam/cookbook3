<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\NoteRepository;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends AbstractController
{
    #[Route('/notes', name: 'app_note', methods: ['GET'])]
    public function index(NoteRepository $noteRepository): Response
    {
        return $this->render('note/index.html.twig', [
            'notes' => $noteRepository->findBy([], ['nom' => 'ASC']),
        ]);
    }

    #[Route('/notes/{id}', name: 'app_recette_note_new', methods: ['GET', 'POST'])]
    public function nouvelleNote(
        int $id,
        RecetteRepository $recetteRepository,
        
        EntityManagerInterface $em,
        Request $request
    ): Response {
        

        $recette = $recetteRepository->find($id);
        if (!$recette) {
            throw $this->createNotFoundException('Recette non trouvée');
        }
        // Noter une recette
        $note = new Note();
        $formNote = $this->createForm(NoteType::class, $note);
        $formNote->handleRequest($request);

        if ($formNote->isSubmitted() && $formNote->isValid()) {
            $note
                ->setAuteur($this->getUser())
                ->setRecette($recette);

            $em->persist($note);
            $em->flush();
            // Ajouter un flash message de succès
            $this->addFlash('success', 'Votre note a été ajoutée avec succès !');


            return $this->redirectToRoute('app_recette_one', ['slug' => $recette->getSlug()]);
        }

        return $this->render('note/note_new.html.twig', [
            'formNote' => $formNote->createView(),
            'recette' => $recette,
           
        ]);
    }

    #[Route('/note/{id}', name: 'app_note_show', methods: ['GET'])]
    public function note(Note $note): Response
    {
        return $this->render('note/note_one.html.twig', [
            'note' => $note,
        ]);
    }
}
