<?php

namespace App\Form;

use App\Entity\Commercial;
use App\Entity\RelanceClient;
use App\Entity\Stagiaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RelanceClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('motif')
            ->add('stagiaire', EntityType::class, [
                'class' => Stagiaire::class,
                'choice_label' => 'id',
            ])
            ->add('commercial', EntityType::class, [
                'class' => Commercial::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RelanceClient::class,
        ]);
    }
}
