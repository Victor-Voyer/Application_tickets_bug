<?php

namespace App\Form;

use App\Entity\Tickets;
use App\Enum\Stacks;
use App\Enum\Types;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Sujet : ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Décrire le sujet du ticket ...'
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Description : ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Détails du problème ...'
                ]
            ])
            ->add('stack', EnumType::class, [
                'label' => 'Techologie : ',
                'required' => true,
                'class' => Stacks::class,
                'choice_label' => fn(Stacks $e) => $e->value,
                'placeholder' => 'Choisir une technologie',
                'expanded' => false,
                'multiple' => false
            ])
            ->add('type', EnumType::class, [
                'label' => 'Catégorie : ',
                'required' => true,
                'class' => Types::class,
                'choice_label' => fn(Types $e) => $e->value,
                'placeholder' => 'Choisir une catégorie',
                'expanded' => false,
                'multiple' => false
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
