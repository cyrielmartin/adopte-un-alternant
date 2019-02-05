<?php

namespace App\Form;

use App\Entity\VisitCard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AboutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
        ->add('about', TextareaType::class, [
            'label' => 'À propos de vous',
            'attr' => [
                'cols' => '5',
                'rows' => '5',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champs ne peut pas être vide'
                ]),
                new Length([
                    'min' => 10,
                    'minMessage' => 'Votre texte doit comporter au moins {{ limit }} charactères',
                    'max' => 1000,
                    'maxMessage' => 'Votre texte ne peut pas excéder {{ limit }} charactères',
                ]),
                ],
            'help' => 'Ce que vous écrivez ici est visible depuis votre profil public',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VisitCard::class,
        ]);
    }
}