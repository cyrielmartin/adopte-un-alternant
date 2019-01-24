<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use App\Repository\RoleRepository;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('firstname', TextType::class, [
            'label'=> 'Prénom',
            'attr' => [
                'placeholder' => 'votre prénom',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez saisir un prénom'
                ]),
            ]
        ])
        ->add('lastname', TextType::class, [
            'label'=>'Nom',
            'attr' => [
                'placeholder' => 'votre nom',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez saisir un nom'
                ]),
            ]
        ])
        ->add('email', EmailType::class, [
            'label'=>'Email',
            'help' => 'Votre adresse email sera votre identifiant de connexion',
            'attr' => [
                'placeholder' => 'votre adresse email',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez saisir un email'
                ]),
                new Email(([
                    'message' => 'Adresse email non valide'
                ]))
            ]
        ])
        ->add('role', EntityType::class, [
            'class' => Role::class,
            'label' => 'Vous êtes :',
            'query_builder' => function (RoleRepository $rr) {
                return $rr->createQueryBuilder('u')
                ->select('u')
                ->where('u.id >= 2');
            },
            'expanded' => true,
            'multiple' => false,             
        ])
        ->add('password', RepeatedType::class, [
            'empty_data' => '',
            'required' => false,
            'type' => PasswordType::class,
            'invalid_message' => 'Les mots de passe saisis ne correspondent pas',
            'first_options'  => [
                'label' => 'Mot de passe',
            ],
            'second_options' => [
                'label' => 'Vérification du mot de passe'
            ],
        ])
            // ->add('token')
            // ->add('status')
            // ->add('createdAt')
            // ->add('updatedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
