<?php

namespace App\Controller\Admin;

use App\Entity\Recette;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RecetteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recette::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [


            IdField::new('id')->onlyOnDetail(),
            FormField::addPanel('Quelle est le nom de la recette ?')
                ->setIcon('cube')
                ->setHelp('Saisissez le nom de la recette'),
            TextField::new('nom'),
            TextField::new('slug')->setHelp('Saisissez le nom de slug'),

            AssociationField::new('categorie')
                ->setHelp('Choisissez la categorie de la recette'),

            FormField::addPanel('Avec une image c\'est mieux !')
                ->setIcon('image')
                ->setHelp('Saisissez l\'image de la recette'),
            ImageField::new('image')
                ->setUploadedFileNamePattern('[contenthash].[extension]')
                ->setBasePath('uploads/recettes')
                ->setUploadDir('public/uploads/recettes'),

            FormField::addPanel('Les ingredients de la recette!')
                ->setIcon('list')
                ->setHelp('Choisissez le nom de l\'ingredient'),

            //AssociationField::new('mesures'),

            CollectionField::new('mesures')->useEntryCrudForm(MesureCrudController::class)->hideOnIndex(),

            //  CollectionField::new('ingredients')->useEntryCrudForm(IngredientCrudController::class),


            FormField::addPanel('Les instructions')
                ->setIcon('utensils'),
            IntegerField::new('portion')->setHelp('Saisissez le nombre de portions')->hideOnIndex(),



            CountryField::new('pays')->setHelp('Saisissez le pays d\'origine du plat')->hideOnIndex(),
            IntegerField::new('preparation')->setHelp('Saisissez le temps de preparation')->hideOnIndex(),
            IntegerField::new('cuisson')->setHelp('Saisissez le temps de cuisson')->hideOnIndex(),
            IntegerField::new('repos')->setHelp('Saisissez le temps de repos')->hideOnIndex(),


            TextEditorField::new('instruction')->setHelp('Saisissez les étapes de la préparation de recette'),

            BooleanField::new('brouillon')->setHelp('Ne pas publier pour le moment'),
            FormField::addRow(),
           








            // TextEditorField::new('description'),
        ];
    }
}
