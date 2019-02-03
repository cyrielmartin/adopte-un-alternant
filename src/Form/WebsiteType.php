<?php

namespace App\Form;

use App\Entity\Website;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class WebsiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du site',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir ce champs'
                    ]),
                ],
            ])
            ->add('link',TextType::class, [
                'label' => 'URL',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir ce champs'
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
