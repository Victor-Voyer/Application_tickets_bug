<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProfileEditType extends AbstractType
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
                'constraints' => [
                    new NotBlank(),
                    new Email(['mode' => 'strict'])
                ],
                'attr' => [
                    'placeholder' => 'ex: user@example.com'
                ],
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
