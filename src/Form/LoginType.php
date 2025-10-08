<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\Regex;

class LoginType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options): void
   {
      $builder
         ->add('email', EmailType::class, [
            'label' => 'Email : ',
            'required' => true,
            'attr' => [
               'placeholder' => 'Email ...'
            ]
         ])
         ->add('password', PasswordType::class, [
            'label' => 'Password : ',
            'required' => true,
            'attr' => [
               'placeholder' => 'Password ...'
            ],
            'constraints' => [
               new NotBlank(message: 'Please enter a password.'),
               new Length(min: 8, minMessage: 'At least {{ limit }} characters.'),
               new Regex(
                  pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/',
                  message: 'Must contain min. 1 lowercase, 1 uppercase, 1 digit and 1 special character.'
               ),
               new NotCompromisedPassword(message: 'This password has been compromised, choose another one.'),
            ]
         ])
         ->add('submit', SubmitType::class, [
            'label' => 'Login',
            'attr' => [
               'class' => 'btn btn-primary'
            ]
         ])
         ->add('forgot_password', ButtonType::class, [
            'label' => 'Mot de passe oublié ?',
            'attr' => [
               'class' => 'btn btn-link forgot-password',
               'onclick' => 'window.location.href = "' . $options['forgot_password_url'] . '"'
            ]
         ])
      ;
   }
   public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver): void
   {
      $resolver->setDefaults([
         'forgot_password_url' => '/forgot-password'
      ]);
   }

   public function getBlockPrefix(): string
   {
      return 'login';
   }

}