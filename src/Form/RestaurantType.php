<?php

namespace App\Form;

use App\Form\AddressType;
use App\Entity\Restaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom du restaurant *",
                'attr' => ['placeholder' => "Au bon Snack"],
                'required' => true,
            ])
            ->add('director', TextType::class, [
                'label' => "Nom du directeur *",
                'attr' => ['placeholder' => "Jean Michel"],
                'required' => true,
            ])
            ->add('address', AddressType::class, [
                'mapped' => true,
                'label' => 'Adresse',
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
        ]);
    }
}
