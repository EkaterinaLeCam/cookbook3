<?php

namespace App\Form;


use App\Entity\Recette;
use App\Model\SearchData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('q', TextType::class, [
            'attr' => [
                'placeholder' => 'Mettez le mot clé...',
                'class' => 'form-control' // Optionnel : Ajout d'une classe CSS
            ],
            'required' => false, // Optionnel : si le champ n'est pas obligatoire
        ]);
}

public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults([
        'data_class' => SearchData::class, // Lier à un DTO si nécessaire
        'method' => 'GET',
        'csrf_protection' => false,
    ]);
}
}
