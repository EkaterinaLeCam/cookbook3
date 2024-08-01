<?php

namespace App\Controller\Admin;

use App\Entity\Mesure;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class MesureCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Mesure::class;
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
            FormField::addPanel('Mettez votre mesure!')
            ->setIcon('scale-unbalanced-flip'),
            IdField::new('id')->onlyOnDetail(),
            AssociationField::new('ingredients')
            ->setLabel('')
            ->setHelp('Choisissez votre ingredient'),
            FormField::addRow('xxl'),
            IntegerField::new('quantite')
            ->setLabel('')
            ->setHelp('quantité'),
            FormField::addRow('xxl'),
            ChoiceField::new('mesure')
            ->setChoices([
                'kg' => 'kg',
                'gr' => 'gr',
                'l' => 'l',
                'ml' => 'ml',
                'cs' => 'cs',
                'cc' => 'cc',
                'pcs' => 'pcs',
                
            ])
            ->setLabel('')
            ->setHelp('mesure'),
            
        ];
    }
    
}
