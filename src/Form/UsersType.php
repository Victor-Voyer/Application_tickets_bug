<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('avatar', FileType::class, [
                'label' => 'Avatar : ',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'ex: Avatar...'
                ],
            ])
            ->add('nickname', TextType::class, [
                'label' => 'Nickname : ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'ex: Nickname...'
                ]
            ])
            ->add('last_name', TextType::class, [
                'label' => 'Last name : ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'ex: SMITH...',
                ]
            ])
            ->add('first_name', TextType::class, [
                'label' => 'First name : ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'ex: Jack...',
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
                'first_options'  => [
                    'label' => 'Password : ',
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'At least 8 characters…',
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirm Password : ',
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'Confirm password...'
                    ],
                ],
                'invalid_message' => 'The two passwords must match.',
                'constraints' => [
                    new NotBlank(message: 'Password is required.'),
                    new Length(min: 8, minMessage: 'At least {{ limit }} characters.'),
                    new Regex(
                        pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/',
                        message: 'Must contain at least 1 lowercase letter, 1 uppercase letter, 1 digit and 1 special character.'
                    ),
                    new NotCompromisedPassword(message: 'This password has been compromised, please choose another one.'),
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
