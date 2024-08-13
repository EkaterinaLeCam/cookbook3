<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use App\Repository\NoteRepository;
use App\Repository\RecetteRepository;
use App\Service\ModerationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NoteController extends AbstractController
{
    #[Route('/notes', name: 'app_note', methods: ['GET'])]
    public function index(NoteRepository $noteRepository): Response
    {
        return $this->render('note/index.html.twig', [
            'notes' => $noteRepository->findBy(
                [],
                ['nom' => 'ASC']
            ),
        ]);
    }
    #[Route('/notes{id}', name: 'app_recette_note_new', methods: ['GET', 'POST'])]

    public function nouvelleNote(

        RecetteRepository $recette,
        NoteRepository $noteRepository,
        EntityManagerInterface $em,
        Request $request,

    ): Response {
        $note= new Note();
        //declaration du formulaire en controller
        $formNote = $this->createForm(NoteType::class, $note);
        $formNote->handleRequest($request);

        if ($formNote->isSubmitted() && $formNote->isValid()) {
            $note = new Note();
            $note
            ->setAuteur($this->getUser())
            ->setRecette($recette);





            $em->persist($note);
            $em->flush();

            return $this->redirectToRoute('app_recette_one');
        }

        return $this->render('note/note_new.html.twig', [
            'formNote' => $formNote->createView(),
            'note' => $note
        ]);
    }
    public function note(Note $note): Response
    {
        return $this->render('note/note_one.html.twig', [
            'note' => $note,
        ]);
    }
}
