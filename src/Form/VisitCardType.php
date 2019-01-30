<?php

namespace App\Form;

use App\Entity\VisitCard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class VisitCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('about', TextareaType::class, [
                'label' => 'À propos de vous',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champs ne peut pas être vide'
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Votre texte doit comporter au moins {{ limit }} mots',
                        'max' => 1000,
                        'maxMessage' => 'Votre texte ne peut pas excéder {{ limit }} mots',
                    ]),
                    ],
                'help' => 'Ce que vous écrivez ici est accessible depuis votre profil public',
            ])
            ->add('adopted', ChoiceType::class, [
                'label' => 'Avez-vous été adopté par une entreprise ?',
                'help' => 'Ne cochez oui que si votre contrat d\'alternance a été signé',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => true,
                'multiple' => false,
            ] )
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
            ] )
            // ->add('skills')
            // ->add('mobilities')
            // ->add('isCandidate')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VisitCard::class,
        ]);
    }
}
