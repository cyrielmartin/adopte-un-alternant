<?php

namespace App\Form;

use App\Entity\Email;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('subject', TextType::class, [
            'data' => 'Votre profil nous intéresse',
            'label'=>'Objet',
            'help'=> 'Vous pouvez modifier l\'objet et/ou le corps du mail ou les valider ainsi.'
            
        ])
        ->add('text', TextareaType::class, [
            'data' => 'Bonjour, nous souhaiterions entrer en contact avec vous pour échanger en vue d\'une éventuelle alternance. Cordialement.',
            'attr' => ['cols' => '5', 'rows' => '5'],
            'label'=>'Message',
            'help' => 'En envoyant ce message, le candidat aura accès à votre adresse email.'
            
        ]);
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Email::class,
        ]);
    }
}
