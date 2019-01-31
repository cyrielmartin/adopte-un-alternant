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
            ->add('visibilityChoice', ChoiceType::class, [
                'label' => 'Sur votre profil public, que souhaitez-vous afficher ?',
                'help' => 'Les entreprises identifiées ont accès à l\'ensemble de vos informations',
                'choices' => [
                    'Prénom et nom' => 1,
                    'Nom uniquement' => 0,
                    'Prénom uniquement' => 2,
                ],
                'expanded' => true,
                'multiple' => false,
            ] );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VisitCard::class,
        ]);
    }
}