<?php

namespace App\Form;

use App\Entity\Evaluation;
use App\Entity\Note;
use App\Entity\Stagiaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('valeur')
            ->add('date')
            ->add('evaluation', EntityType::class, [
                'class' => Evaluation::class,
                'choice_label' => 'id',
            ])
            ->add('stagiaiare', EntityType::class, [
                'class' => Stagiaire::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
