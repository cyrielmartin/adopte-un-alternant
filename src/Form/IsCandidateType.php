<?php

namespace App\Form;

use App\Entity\IsCandidate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class IsCandidateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phoneNumber', TelType::class, [
                'label'=>'Votre numéro de téléphone',
                'attr' => [
                    'placeholder' => 'Veuillez saisir un numéro de téléphone valide',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champs ne peut pas être vide'
                    ]),
                ]
            ])
            // ->add('pictureFile')
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
