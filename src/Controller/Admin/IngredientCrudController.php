<?php

namespace App\Controller\Admin;

use App\Entity\Ingredient;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
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

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail(),
            TextField::new('nom'),

            FormField::addPanel('Avec une image c\'est mieux !')
                ->setIcon('image')
                ->setHelp('Saisissez l\'image de la recette'),
            ImageField::new('image')
                ->setUploadedFileNamePattern('[contenthash].[extension]')
                ->setBasePath('uploads/ingredients')
                ->setUploadDir('public/uploads/ingredients')
        ];
    }
    
}
