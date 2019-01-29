<?php

namespace App\Form;

use App\Form\FormationBaseType;
use App\Entity\IsApprenticeship;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApprenticeshipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('formation', FormationBaseType::class)
            ->add('academicPace')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => IsApprenticeship::class,
        ]);
    }
}
