<?php

namespace App\Form;

use App\Entity\FormateurValidation;
use App\Entity\Formateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormateurValidationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('formateur', EntityType::class, [
                'class' => Formateur::class,
                'choice_label' => 'nom', // Assure-toi que la propriété 'nom' existe dans l'entité Formateur
                'label' => 'Formateur',
            ])
            ->add('dateValidation', CheckboxType::class, [
                'label' => 'Validation effectuée',
                'required' => false,
            ])
            ->add('pedagogiquementValide', CheckboxType::class, [
                'label' => 'Validation pédagogique',
                'required' => false,
            ])
            ->add('premiereFois', CheckboxType::class, [
                'label' => 'Première intervention',
                'required' => false,
            ])
            ->add('commentaire', TextareaType::class, [
                'label' => 'Commentaire',
                'required' => false,
                'attr' => ['rows' => 4],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormateurValidation::class,
        ]);
    }
}
