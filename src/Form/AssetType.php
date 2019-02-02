<?php

namespace App\Form;

use App\Entity\Additional;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class AssetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('typeInfo')
            ->add('content', TextType::class, [
                'label' => 'Atout',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un atout'
                    ]),
                ],
            ])
            //->add('visitCard')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Additional::class,
        ]);
    }
}
