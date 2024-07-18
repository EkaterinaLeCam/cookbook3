<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Entity\Ingredient;
use App\Entity\Recette;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Cookbook3');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Administrateur', 'fa fa-home');
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Categorie::class);
        yield MenuItem::linkToCrud('Ingredients', 'fas fa-list', Ingredient::class);
        yield MenuItem::linkToCrud('Recettes', 'fas fa-list', Recette::class);
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-list', Commentaire::class);

        // yield MenuItem::linkToLogout('Déconnexion', 'fas fa-sign-out-alt');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
