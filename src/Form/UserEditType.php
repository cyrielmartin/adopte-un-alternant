<?php
namespace App\Form;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('firstname', TextType::class, [
            'label'=> 'Prénom',
            'attr' => [
                'placeholder' => 'Votre prénom',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez saisir un prénom'
                ]),
            ],
            'empty_data' => '',
        ])
        ->add('lastname', TextType::class, [
            'label'=>'Nom',
            'attr' => [
                'placeholder' => 'Votre nom',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez saisir un nom'
                ]),
            ],
            'empty_data' => '',
        ])
        ->add('email', EmailType::class, [
            'label'=>'Email',
            'attr' => [
                'placeholder' => 'email@example.com',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez saisir un email'
                ]),
                new Email(([
                    'message' => 'Adresse email non valide'
                ]))
            ],
            'empty_data' => '',
        ])
        ->add('password', RepeatedType::class, [
            'required' => false,
            'type' => PasswordType::class,
            'invalid_message' => 'Les mots de passe saisis ne correspondent pas',
            'first_options'  => [
                'label' => 'Mot de passe',
                'attr' => [
                    'placeholder' => 'Laisser vide si inchangé',
                ],
            ],
            'second_options' => [
                'label' => 'Vérification du mot de passe',
                'attr' => [
                    'placeholder' => 'Laisser vide si inchangé',
                ],
            ],
            'empty_data' => '',
        ])
            // ->add('token')
            // ->add('status')
            // ->add('createdAt')
            // ->add('updatedAt')
            // ->add('role')
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}