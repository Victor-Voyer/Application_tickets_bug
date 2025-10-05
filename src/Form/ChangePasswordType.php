<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\Regex;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('currentPassword', PasswordType::class, [
                'label' => 'Current password : ',
                'required' => true,
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Your current password...',
                    'autocomplete' => 'current-password',
                ],
                'constraints' => [
                    new NotBlank(message: 'The current password is required.'),
                ],
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'required' => true,
                'first_options'  => [
                    'label' => 'New password : ',
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'At least 8 characters...',
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirm the new password : ',
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'Confirm the password...'
                    ],
                ],
                'invalid_message' => 'The two passwords must match.',
                'constraints' => [
                    new NotBlank(message: 'The password is required.'),
                    new Length(min: 8, minMessage: 'At least {{ limit }} characters.'),
                    new Regex(
                        pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/',
                        message: 'Must contain at least 1 lowercase, 1 uppercase, 1 digit and 1 special character.'
                    ),
                    new NotCompromisedPassword(message: 'This password has been compromised, please choose another one.'),
                ],
            ])
        ;
    }
}
