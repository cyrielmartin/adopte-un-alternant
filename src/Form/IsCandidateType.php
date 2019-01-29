<?php

namespace App\Form;

use App\Entity\IsCandidate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeExtensionGuesser;

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
            ->add('pictureFile', VichImageType::class, [
                'allow_delete' => true, // not mandatory, default is true
                'download_link' => false, // not mandatory, default is true
                'label' => 'Votre photo',
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
