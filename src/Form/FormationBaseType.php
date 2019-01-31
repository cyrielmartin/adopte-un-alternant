<?php

namespace App\Form;

use App\Entity\School;
use App\Entity\Formation;
use App\Entity\AwardLevel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FormationBaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('school', TextType::class, [
                'label' => 'Au sein de quel établissement comptez vous effectuer votre formation ?',
            ])
            ->add('awardName', TextType::class, [
                'label' => 'Nom du diplôme à obtenir suite à la formation :',
            ])
            ->add('awardLevel', EntityType::class,[
                'label'=>'Niveau du diplôme ou équivalent :',
                'class'=> AwardLevel::class,
                'choice_label'=>'name',
                'multiple'=>false,
                'expanded'=>false,
            ])
            ->add('startedAt', DateType::class, [
                'label' => 'La formation commencera le :',
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
            ])
            ->add('endedAt', DateType::class, [
                'label' => 'Et se finira le :',
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
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