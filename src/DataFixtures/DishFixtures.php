<?php

namespace App\DataFixtures;

use App\Entity\Dish;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\IngredientFixtures;
use App\Repository\IngredientRepository;
use App\Repository\RestaurantRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DishFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        IngredientRepository $ingredientRepository, 
        RestaurantRepository $restaurantRepository
    )
    {
        $this->ingredientRepository = $ingredientRepository;
        $this->restaurantRepository = $restaurantRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $ingredients = $this->ingredientRepository->findAll();
        $restaurants = $this->restaurantRepository->findAll();

        $dishNames = ['Entrée', 'Plat', 'Dessert'];


        for ($i=0; $i < count($restaurants); $i++) { 
            for ($j=0; $j < count($dishNames); $j++) { 
                $dish = new Dish();

                $dish->setName($dishNames[$j])
                    ->setPrice(mt_rand(10, 25))
                    ->setRestaurant($restaurants[$i]) 
                ;

                $indexes = [0, 1, 2, 3, 4, 5, 6, 7, 8];

                for ($k=0; $k < 3; $k++) { 
                    $offset = mt_rand(0 , count($indexes) - 1);

                    $index = array_splice($indexes, $offset, 1)[0];

                    $dish->addIngredient($ingredients[$index]);
                }

                $manager->persist($dish);
            } 
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            IngredientFixtures::class,
            RestaurantFixtures::class,
        );
    }
}
