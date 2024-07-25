<?php

namespace App\Controller\Admin;

use App\Entity\Recette;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
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
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
    ;
}

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail(),
            FormField::addPanel('Quelle est le nom de la recette ?')
                ->setIcon('cube')
                ->setHelp('Saisissez le nom de la recette'),
            TextField::new('nom'),

            FormField::addPanel('Avec une image c\'est mieux !')
                ->setIcon('image')
                ->setHelp('Saisissez l\'image de la recette'),
            ImageField::new('image')
                ->setUploadedFileNamePattern('[contenthash].[extension]')
                ->setBasePath('uploads/recettes')
                ->setUploadDir('public/uploads/recettes')
            // TextEditorField::new('description'),
        ];
    }
}
