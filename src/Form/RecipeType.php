<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '50',
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                "required" => true,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'minMessage' => "le contenu ne doit pas faire moins de 2 caractères", "max" => 50, "maxMessage" => "le contenu ne doit pas faire plus de 50 caractères"]),
                    new Assert\NotBlank(["message" => "Le contenu ne doit pas être vide"])
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                "required" => true,
                'constraints' => [
                    new Assert\NotBlank(["message" => "Le contenu ne doit pas être vide"])
                ]
            ])
            ->add('prepareTime', TimeType::class, [
                'label' => 'Temps de préparation',
                'input' => 'datetime',
                'widget'  => 'choice',
                "required" => true,
                'constraints' => [
                    new Assert\NotBlank(["message" => "Le contenu ne doit pas être vide"])
                ]
            ])
            ->add('restTime', TimeType::class, [
                'label' => 'Temps de repos',
                'input' => 'datetime',
                'widget'  => 'choice',
                "required" => true,
                'constraints' => [
                    new Assert\NotBlank(["message" => "Le contenu ne doit pas être vide"])
                ]
            ])
            ->add('cookingTime', TimeType::class, [
                'label' => 'Temps de cuisson',
                'input' => 'datetime',
                'widget'  => 'choice',
                "required" => true,
                'constraints' => [
                    new Assert\NotBlank(["message" => "Le contenu ne doit pas être vide"])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
