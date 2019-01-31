<?php

namespace App\Form;

use App\Entity\School;
use App\Entity\Formation;
use App\Entity\AwardLevel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FormationBaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('school', TextType::class, [
                'label' => 'Nom de l\'établissement de formation :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un établissement'
                    ]),
                ],
            ])
            ->add('awardName', TextType::class, [
                'label' => 'Nom du diplôme :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le nom du diplôme'
                    ]),
                ],
                'empty_data' => '',
            ])
            ->add('awardLevel', EntityType::class,[
                'label'=>'Niveau du diplôme ou équivalent :',
                'class'=> AwardLevel::class,
                'choice_label'=>'name',
                'multiple'=>false,
                'expanded'=>false,
            ])
            ->add('startedAt', DateType::class, [
                'label' => 'Début de la formation :',
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
                'years' => range(date('Y')-10, date('Y')+5),
            ])
            ->add('endedAt', DateType::class, [
                'label' => 'Fin de la formation :',
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
                'years' => range(date('Y')-10, date('Y')+5),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}