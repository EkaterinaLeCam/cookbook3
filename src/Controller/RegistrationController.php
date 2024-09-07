<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register( RecetteRepository $recetteRepository, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        //Barre de recherche
         // Créer une instance de SearchData pour capturer les données du formulaire
         $searchData = new SearchData();

         // Créer le formulaire de recherche en utilisant le type de formulaire SearchType
         $formSearch = $this->createForm(SearchType::class, $searchData);
 
         // Gérer la requête pour extraire les données du formulaire
         $formSearch->handleRequest($request);
 
         // Initialiser les recettes à null et les charger conditionnellement
         $recettes = $formSearch->isSubmitted() && $formSearch->isValid()
             ? $recetteRepository->findByQuery($searchData->getQ())
             : $recetteRepository->findAll();
 
         // Rendre la vue avec les recettes et le formulaire de recherche
        // Registration de  nouveau utilisateur
        $user = new Utilisateur();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
            'recettes' => $recettes,
            'formSearch' => $formSearch->createView(),
        ]);
    }
}
