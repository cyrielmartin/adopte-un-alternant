<?php

namespace App\Form;

use App\Entity\School;
use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FormationBaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('schools', EntityType::class, [
                'class' => School::class,
                'choice_label' => 'name',
                'label' => 'Au sein de quel établissement allez vous effectuer votre alternance ?',
                'expanded' => false,
                'multiple' => false,
                'required' => false,
            ])
            ->add('school', TextType::class, [
                'label' => 'Vous ne le trouvez pas ? Ajoutez le',
            ])
            ->add('awardName')
            ->add('awardLevel')
            ->add('startedAt')
            ->add('endedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
