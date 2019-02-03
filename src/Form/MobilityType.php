<?php

namespace App\Form;

use App\Entity\Mobility;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MobilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('townName', TextType::class, [
                'label' => 'Nom de la ville',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une ville'
                    ]),
                ],
            ])
            //->add('department')
            //->add('visitCards')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mobility::class,
        ]);
    }
}
