<?php

namespace App\Form;

use App\Entity\IsRecruiter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecruiterFavoriteCandidateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companyName')
            ->add('phoneNumber')
            ->add('companyLocation')
            ->add('emailCustom')
            ->add('user')
            ->add('isCandidates')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => IsRecruiter::class,
        ]);
    }
}
