<?php

namespace App\Form;

use App\Entity\Note;
use App\Entity\Recette;
use App\Entity\Utilisateur;
use DateTimeInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        // ChoiceType::class, tu mets le choix de 1 à 5.
        ->add('etoile', IntegerType::class, [
            'label' => 'Votre note',
            'required' => true,
            'attr' => [
                'min' => 1,
                'max' => 5,
                'placeholder' => 'Choisissez une note (1-5)',
            ],
        ])
        ->add('recette', HiddenType::class, [
            'mapped' => false, // Ce champ est utilisé pour passer l'ID de la recette
        ])
        ->add('auteur', HiddenType::class, [
            'mapped' => false, // Ce champ est utilisé pour passer l'ID de l'utilisateur
        ]);
}

public function configureOptions(OptionsResolver $resolver): void
{
    $resolver->setDefaults([
        'data_class' => Note::class,
    ]);
}
}
