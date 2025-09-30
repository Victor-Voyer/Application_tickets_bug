<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
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
                'label' => 'Pseudo : ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre pseudo ...'
                ]
            ])
            ->add('first_name', TextType::class, [
                'label' => 'Nom : ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre Nom ...'
                ]
            ])
            ->add('last_name', TextType::class, [
                'label' => 'Prénom : ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre Prénom ...'
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
            ->add('password',RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,              
                'required' => true,
                'first_options'  => [
                    'label' => 'Mot de passe : ',
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'Au moins 8 caractères…',
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe : ',
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'Confirmez le mot de passe ...'
                    ],
                ],
                'invalid_message' => 'Les deux mots de passe doivent être identiques.',
                'constraints' => [
                    new NotBlank(message: 'Veuillez saisir un mot de passe.'),
                    new Length(min: 8, minMessage: 'Au moins {{ limit }} caractères.'),
                    new Regex(
                        pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/',
                        message: 'Doit contenir min. 1 minuscule, 1 majuscule, 1 chiffre et 1 caractère spécial.'
                    ),
                    new NotCompromisedPassword(message: 'Ce mot de passe a été compromis, choisissez-en un autre.'),
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
