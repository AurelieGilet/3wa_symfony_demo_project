<?php

namespace App\Form;

use App\Entity\Dish;
use App\Entity\Ingredient;
use App\Entity\Restaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom du plat *",
                'attr' => ['placeholder' => "Spaghettis bolognaises"],
                'required' => true,
            ])
            ->add('price', NumberType::class, [
                'label' => "Prix du plat *",
                'attr' => ['placeholder' => "42"],
                'scale' => 2,
                'required' => true,
            ])
            
            ->add('restaurant', EntityType::class, [
                "class"=> Restaurant::class,
                "choice_label"=>"name",
                "multiple"=>false,
                "expanded"=>false,
                'required' => true,
            ])
            ->add('ingredients', EntityType::class, [
                "class"=> Ingredient::class,
                "choice_label"=>"name",
                "multiple"=>true,
                "expanded"=>true,
                'required' => true,
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dish::class,
        ]);
    }
}
