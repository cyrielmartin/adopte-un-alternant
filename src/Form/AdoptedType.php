<?php

namespace App\Form;

use App\Entity\VisitCard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AdoptedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('about')
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
            // ->add('visibilityChoice')
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
