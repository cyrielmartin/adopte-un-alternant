<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use App\Repository\RoleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

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
                ->where('u.code = :candidate')
                ->orWhere('u.code = :recruiter')
                ->setParameter('candidate' , 'ROLE_CANDIDATE')
                ->setParameter('recruiter' , 'ROLE_RECRUITER');
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
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez saisir un mot de passe'
                ]),
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}