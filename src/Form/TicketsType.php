<?php

namespace App\Form;

use App\Entity\Tickets;
use App\Enum\Stacks;
use App\Enum\Types;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TicketsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Subject : ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Describe the subject of the ticket ...'
                ]
            ])            
            ->add('stack', EnumType::class, [
                'label' => 'Technology : ',
                'required' => true,
                'class' => Stacks::class,
                'choice_label' => fn(Stacks $e) => $e->value,
                'placeholder' => 'Choose a technology',
                'expanded' => false,
                'multiple' => false
            ])
            ->add('type', EnumType::class, [
                'label' => 'Category : ',
                'required' => true,
                'class' => Types::class,
                'choice_label' => fn(Types $e) => $e->value,
                'placeholder' => 'Choose a category',
                'expanded' => false,
                'multiple' => false
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Description : ',
                'required' => false,
                'constraints' => [
                    new NotBlank(message: 'Please write a description.'),
                ],
                'attr' => [
                    'class' => 'js-ckeditor',
                    
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tickets::class,
        ]);
    }
}
