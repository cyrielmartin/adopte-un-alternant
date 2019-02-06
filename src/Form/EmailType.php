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
            'label'=>'objet',
            'help'=> 'vous pouvez modifier l\'objet du mail ou l\'envoyer ainsi'
            
        ])
        ->add('text', TextareaType::class, [
            'data' => 'Nous souhaiterions entrer en contact avec vous pour échanger en vue d\'une éventuelle collaboration',
            'attr' => ['cols' => '5', 'rows' => '5'],
            'label'=>'message',
            'help'=> 'vous pouvez modifier le contenu de ce message ou l\'envoyer ainsi'
            
        ]);
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Email::class,
        ]);
    }
}
