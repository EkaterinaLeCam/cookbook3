<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categorie::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
        //- Ajouter la fonction de voir les ingredients
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel('Saisissez votre catégorie!')
            ->setIcon('angle-double-down'),
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
         
        ];
    }
}
