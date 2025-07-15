<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\SousTheme;
use App\Entity\Theme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SousThemeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('theme', EntityType::class, [
                'class' => Theme::class,
                'choice_label' => 'id',
            ])
            ->add('formations', EntityType::class, [
                'class' => Formation::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SousTheme::class,
        ]);
    }
}
