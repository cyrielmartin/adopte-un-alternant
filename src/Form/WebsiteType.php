<?php

namespace App\Form;

use App\Entity\Website;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WebsiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Atout',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un site'
                    ]),
                ],
            ])
            ->add('link',TextType::class, [
                'label' => 'Atout',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un site'
                    ]),
                ],
            ])
            //->add('visitCard')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Website::class,
        ]);
    }
}
