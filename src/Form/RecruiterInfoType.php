<?php

namespace App\Form;

use App\Entity\IsRecruiter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecruiterInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companyName', TextType::class, [
                'label' => 'Nom de l\'entreprise :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une entreprise'
                    ])
                ]
            ])
            ->add('phoneNumber', TelType::class, [
                'label' => 'Numéro de téléphone',
                'help' => 'Facultatif',
            ])
            ->add('companyLocation', TextType::class, [
                'label' => 'Nom de la ville',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une ville'
                    ]),
                ],
            ])
            ->add('emailCustom', TextType::class, [
                'label' => 'Nom de la ville',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une ville'
                    ]),
                ],
            ])
            //->add('user')
            //->add('isCandidates')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => IsRecruiter::class,
        ]);
    }
}
