<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CommentaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commentaire::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
        //- Ajouter la fonction de voir les commentaires
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        //- Masquer la fonction de modification des commentaires
            ->remove(Crud::PAGE_INDEX, Action::EDIT);
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            AssociationField::new('recette'),
            TextField::new('auteur'),
            TextEditorField::new('contenu'),
            BooleanField::new('statut'),
        ];
    }
    
}
