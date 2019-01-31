<?php

namespace App\Form;

use App\Entity\Formation;
use App\Form\FormationBaseType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('formation', FormationBaseType::class, [
                'label' => false,
            ])
            ->add('obtainedAt', DateType::class, [
                'label' => 'Date d\'obtention du diplôme',
                'widget' => 'choice',
                'years' => range(date('Y')-10, date('Y')),
                'format' => 'dd-MM-yyyy',
                'help' => 'Laissez vide si vous n\'avez pas obtenu le diplôme ou que vous êtes toujours en formation',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}