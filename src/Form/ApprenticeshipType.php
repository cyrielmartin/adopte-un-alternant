<?php

namespace App\Form;

use App\Form\FormationBaseType;
use App\Entity\IsApprenticeship;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ApprenticeshipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('formation', FormationBaseType::class, [
                'label' => false,
            ])
            ->add('academicPace', TextType::class, [
                'label' => 'Quel sera le rythme de la formation ?',
                'help' => 'exemple : 1 semaine en formation, 1 semaine en entreprise',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => IsApprenticeship::class,
        ]);
    }
}