<?php

namespace App\Form;

use App\Entity\Dish;
use App\Entity\Menu;
use App\Entity\Restaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'label' => "Nom du menu *",
            'attr' => ['placeholder' => "Formule du jour"],
            'required' => true,
        ])
        ->add('price', NumberType::class, [
            'label' => "Prix du menu *",
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
        ->add('dishes', EntityType::class, [
            "class"=> Dish::class,
            'choice_label' => function ($dish) {
                return $dish->getName() . ' : ' . $dish->getPrice() . '€ - ' . $dish->getRestaurant()->getName();
            },
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
            'data_class' => Menu::class,
        ]);
    }
}
