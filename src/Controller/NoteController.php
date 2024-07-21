<?php

namespace App\Controller;

use App\Entity\Note;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NoteController extends AbstractController
{
    #[Route('/notes', name: 'app_note')]
    public function index(NoteRepository $noteRepository): Response
    {
        return $this->render('note/index.html.twig', [
            'notes' => $noteRepository->findBy(
                [],
                ['nom'=>'ASC']
            ),
        ]);
    }
    #[Route('/notes{id}', name: 'app_note_one')]
    public function note(Note $note): Response
    {
        return $this->render('note/note_one.html.twig', [
            'note' => $note,
        ]);
    }
}
