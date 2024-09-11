<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\RecetteRepository;
use Knp\Component\Pager\PaginatorInterface;
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
        Request $request,  PaginatorInterface $paginator
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
           
   
           // Pagination
           $pagination = $paginator->paginate(
               $queryBuilder, /* query NOT result */
               $request->query->getInt('page', 1), /* page number */
               10 /* limit per page */
           );
   
           return $this->render('page/accueil.html.twig', [
               'recettes' => $pagination,
               'formSearch' => $formSearch->createView(),
           ]);
       } else {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error,
           
            'formSearch' => $formSearch->createView(),]);
    }}

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
