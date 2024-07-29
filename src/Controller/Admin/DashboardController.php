<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Entity\Ingredient;
use App\Entity\Mesure;
use App\Entity\Note;
use App\Entity\Recette;
use App\Entity\Utilisateur;
use App\Repository\RecetteRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private RecetteRepository $recetteRepository;
    public function __construct(RecetteRepository $recetteRepository){
        $this->recetteRepository = $recetteRepository;
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        $recettes=$this->recetteRepository->findAll();
        return $this->render('admin/dashboard.html.twig', [
            'recettes' => $recettes
        ])
        ;
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Cookbook3');
    }
    //aficher sur la page d'admin modifier ou supprimer un élément

    public function configureCrud(): Crud
    {
    return parent::configureCrud()
    ->showEntityActionsInlined();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Administrateur', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateur','fas fa-users', Utilisateur::class);
        yield MenuItem::linkToCrud('Categories','fas fa-angle-double-down', Categorie::class);
        yield MenuItem::linkToCrud('Ingredients', 'fas fa-list', Ingredient::class);
        yield MenuItem::linkToCrud('Mesures', 'fa-solid fa-scale-unbalanced-flip', Mesure::class);
        yield MenuItem::linkToCrud('Recettes', 'fas fa-cutlery', Recette::class);
        yield MenuItem::linkToCrud('Notes', 'fa-solid fa-star-half-stroke', Note::class);
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-comments', Commentaire::class);


    }
}
