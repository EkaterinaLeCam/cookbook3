<?php

namespace App\Controller\Admin;

use App\Entity\Mesure;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
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

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail(),
            AssociationField::new('ingredients'),
            IntegerField::new('quantite'),
            TextField::new('mesure'),
            
        ];
    }
    
}
