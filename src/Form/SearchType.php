<?php

namespace App\Form;

use App\Model\SearchData;
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
            'attr'=>[
                'placeholder' => 'Cherchez une recette'
            ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=> SearchData::class,
            'method'=> 'GET',
            //CSRF : principes, impacts et bonnes pratiques sécurité
            'csrf_protection'=>false
        ]);
    }
}
