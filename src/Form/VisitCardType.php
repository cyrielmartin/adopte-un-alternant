<?php

namespace App\Form;

use App\Entity\VisitCard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisitCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('about')
            ->add('adopted')
            ->add('visibilityChoice')
            ->add('skills')
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
