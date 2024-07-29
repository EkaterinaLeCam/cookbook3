<?php

namespace App\Controller\Admin;

use App\Entity\Note;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class NoteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Note::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
        //- Ajouter la fonction de voir les notes
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        //- Masquer la fonction de modification des notes
            ->remove(Crud::PAGE_INDEX, Action::EDIT);
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail(),
            AssociationField::new('recette')->setHelp('Choisissez votre recette'),
            TextField::new('auteur')->setHelp('Mettez votre nom'),
            IntegerField::new('etoile')->setHelp('Saisissez votre note'),
        ];
    }
    
}
