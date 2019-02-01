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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class ExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companyName', TextType::class, [
                'label' => 'Nom de l\'entreprise :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une entreprise'
                    ]),
                ],
            ])
            

            ->add('status',CheckboxType ::class, [
                'label' =>
                    'J\'occupe actuellement ce poste'       
            ])

            ->add('startedAt', DateType::class, [
                'label' => 'Date de début :',
                'widget' => 'choice',
                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,
                'format' => 'dd-MM-yyyy',
                'constraints' => [
                    new LessThanOrEqual("today UTC"),
                ]             
            ])
            
            ->add('endedAt', DateType::class, [
                'label' => 'Date de fin :',
                'widget' => 'choice',
                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,
                'required' => false,
                'format' => 'dd-MM-yyyy',
                'constraints' => [
                    new LessThanOrEqual("today UTC"),
                    ]
            ])

            ->add('description',TextareaType::class, [
                'label' => 'Décrivez votre expérience :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une description'
                    ]),
                ],
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
