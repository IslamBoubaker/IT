<?php

namespace App\Form;

use App\Entity\Inscription;
use App\Entity\Session;
use App\Entity\Stagiaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('session', EntityType::class, [
                'class' => Session::class,
                'choice_label' => 'id',
            ])
            ->add('stagiaire', EntityType::class, [
                'class' => Stagiaire::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
