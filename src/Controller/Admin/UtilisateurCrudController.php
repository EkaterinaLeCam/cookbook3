<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Config\Security\PasswordHasherConfig;

class UtilisateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Utilisateur::class;
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
            FormField::addPanel('Saisissez vos données personelles!')
            ->setIcon('users'),
            IdField::new('id')->onlyOnDetail(),
            EmailField::new('email')
            ->setHelp('Email'),
            ArrayField::new('roles')->setHelp('Users'),
            TextField::new('prenom')->setHelp('mettez votre prénom'),
            FormField::addPanel('Avec une image c\'est mieux !')
                ->setIcon('image')
                ->setHelp('Mettez votre avatar'),
            ImageField::new('image')
                ->setUploadedFileNamePattern('[contenthash].[extension]')
                ->setBasePath('uploads/users')
                ->setUploadDir('public/uploads/users'),
            
        ];
    }
    
}
