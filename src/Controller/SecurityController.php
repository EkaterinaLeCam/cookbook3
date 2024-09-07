<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(
        AuthenticationUtils $authenticationUtils,
        RecetteRepository $recetteRepository,
        Request $request
    ): Response {
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
        if ($this->getUser()) {
            
            return $this->redirectToRoute('app_accueil', [
                'recettes' => $recettes,
                'formSearch' => $formSearch->createView(),
            ]);
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error,
            'recettes' => $recettes,
            'formSearch' => $formSearch->createView(),]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
