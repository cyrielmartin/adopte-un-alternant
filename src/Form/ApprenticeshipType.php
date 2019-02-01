<?php

namespace App\Form;

use App\Form\FormationBaseType;
use App\Entity\IsApprenticeship;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
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
                'label' => 'Rythme de formation souhaité :',
                'help' => 'Par exemple, une semaine en formation, deux semaines en entreprise.',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre rythme scolaire'
                    ]),
                ],
                'empty_data' => '',
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