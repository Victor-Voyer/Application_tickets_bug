<?php

namespace App\Form;

use App\Entity\Comments;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;

class CommentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', null, [
                'label' => 'Your comment',
                'attr' => [
                    'class' => 'js-ckeditor',
                    'rows' => 5,
                    'placeholder' => 'Write your comment here...'
                ]
            ])
            ->add('imageFiles', FileType::class, [
                'label' => 'Attach images (JPG, PNG, max 5MB) :',
                'mapped' => false,
                'required' => false,
                'multiple' => true,
                'constraints' => [
                    new All([
                        new File([
                            'maxSize' => '5M',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ],
                            'mimeTypesMessage' => 'Please upload a valid image (JPG, PNG or WebP)',
                        ])
                    ])
                ],
                'attr' => [
                    'accept' => 'image/*'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
