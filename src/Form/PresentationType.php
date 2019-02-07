<?php

namespace App\Form;

use App\Entity\Presentation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PresentationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('phoneNumber', TelType::class, [
            'label' => 'Numéro de téléphone',
            'help' => 'Facultatif',
        ])
        ->add('visibilityChoice', ChoiceType::class, [
            'label' => 'Sur votre profil public, que souhaitez-vous afficher ?',
            'help' => 'Les entreprises identifiées ont accès à l\'ensemble de vos informations',
            'choices' => [
                'Prénom et nom' => 0,
                'Nom uniquement' => 1,
                'Prénom uniquement' => 2,
            ],
            'expanded' => true,
            'multiple' => false,
        ] );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Presentation::class,
        ]);
    }
}
