<?php

namespace App\Form;

use App\Entity\Skill;
use App\Entity\Mobility;
use App\Entity\VisitCard;
use App\Entity\AwardLevel;
use App\Entity\SearchCandidate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SearchCandidateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('skills', EntityType::class,[
                'required'=>false,
                'label'=>'Par compétence :',
                'class'=> Skill::class,
                'choice_label'=>'name',
                'multiple'=>true,
                'expanded'=>true,
            ])
            ->add('mobilities', EntityType::class,[
                'required'=>false,
                'label'=>'Par ville :',
                'class'=> Mobility::class,
                'choice_label'=>'townName',
                'multiple'=>true,
                'expanded'=>true,
            ])
            ->add('awards', EntityType::class,[
                'required'=>false,
                'label'=>'Par diplôme :',
                'class'=> AwardLevel::class,
                'choice_label'=>'name',
                'multiple'=>true,
                'expanded'=>true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchCandidate::class,
            'method'=>'get',
            'csrf_protection'=>false
        ]);
    }

    public function getBlockPrefix() {
        return''; // astuce pour avoir une url plus jolie de recherche et pas un truc indéchiffrable
    }
}
