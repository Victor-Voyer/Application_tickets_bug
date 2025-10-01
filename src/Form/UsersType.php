<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\Regex;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nickname', TextType::class, [
                'label' => 'Username : ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Your Username ...'
                ]
            ])
            ->add('first_name', TextType::class, [
                'label' => 'Last Name : ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Your First Name ...'
                ]
            ])
            ->add('last_name', TextType::class, [
                'label' => 'First Name : ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Your Last Name ...'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email : ',
                'required' => true,
                // Validations serveur
                'constraints' => [
                    // Interdit les valeurs "vides"
                    new NotBlank(),
                    // Vérifie que la string est un format d'email valide (renforcé par "['mode' => 'strict']") 
                    new Email(['mode' => 'strict'])
                ],
                'attr' => [
                    'placeholder' => 'ex: user@example.com'
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'required' => true,
                'first_options' => [
                    'label' => 'Password : ',
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'At least 8 characters…',
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirm the password : ',
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'Confirm the password ...',
                    ],
                ],
                'invalid_message' => 'The two passwords must be identical.',
                'constraints' => [
                    new NotBlank(message: 'Please enter a password.'),
                    new Length(min: 8, minMessage: 'At least {{ limit }} characters.'),
                    new Regex(
                        pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/',
                        message: 'Must contain min. 1 lowercase, 1 uppercase, 1 digit and 1 special character.'
                    ),
                    new NotCompromisedPassword(message: 'This password has been compromised, choose another one.'),
                ],
                'options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                    ],
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
