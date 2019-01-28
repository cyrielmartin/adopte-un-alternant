<?php

namespace App\Form;

use App\Entity\IsCandidate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class IsCandidateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phoneNumber', TelType::class, [
                'label'=>'Numéro de téléphone',
                'attr' => [
                    'placeholder' => 'Veuillez saisir un numéro de téléphone valide',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champs ne peut pas être vide'
                    ]),
                ]
            ])
            ->add('picture', FileType::class, [
                'data_class' => null,
                'attr' => [
                    'placeholder' => 'Taille de fichier maximale : 20Ko',
                ],
                'label'=>'Photo',
                'help' => 'Facultatif',
            ])
            // ->add('user')
            // ->add('isRecruiters')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => IsCandidate::class,
        ]);
    }
}
