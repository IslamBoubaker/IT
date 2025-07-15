<?php

namespace App\Form;

use App\Entity\ChecklistLogistique;
use App\Entity\Session;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChecklistLogistiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reservationSalle')
            ->add('machinesInstallees')
            ->add('formateurConfirme')
            ->add('supportsImprimes')
            ->add('convocationsEnvoyees')
            ->add('session', EntityType::class, [
                'class' => Session::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ChecklistLogistique::class,
        ]);
    }
}
