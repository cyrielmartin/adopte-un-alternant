<?php

namespace App\Form;

use App\Entity\Experience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companyName', TextType::class, [
                'label' => 'Nom de l\'entreprise',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une entreprise'
                    ]),
                ],
            ])
            ->add('startedAt', DateType::class, [
                'label' => 'Date de début :',
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
            ])
            ->add('status',CheckboxType ::class, [
                'label' =>
                    'J\'occupe actuellement ce poste'       
            ])
            ->add('endedAt', DateType::class, [
                'label' => 'Date de fin :',
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
            ])
            ->add('description',TextType::class, [
                'label' => 'Décrivez votre expérience',
            ])
            //->add('visitCard')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Experience::class,
        ]);
    }
}
