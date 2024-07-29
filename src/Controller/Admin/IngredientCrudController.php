<?php

namespace App\Controller\Admin;

use App\Entity\Ingredient;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class IngredientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ingredient::class;
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
            FormField::addPanel('Saisissez votre Ingredient!')
            ->setIcon('list'),
            IdField::new('id')->onlyOnDetail(),
            TextField::new('nom'),

            FormField::addPanel('Avec une image c\'est mieux !')
                ->setIcon('image')
                ->setHelp('Saisissez l\'image de la recette'),
            ImageField::new('image')
                ->setUploadedFileNamePattern('[contenthash].[extension]')
                ->setBasePath('uploads/ingredients')
                ->setUploadDir('public/uploads/ingredients'),
            CollectionField::new('mesures'),
        ];
    }
    
}
