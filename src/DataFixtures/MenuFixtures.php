<?php

namespace App\DataFixtures;

use App\Entity\Menu;
use App\DataFixtures\DishFixtures;
use App\Repository\DishRepository;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\RestaurantFixtures;
use App\Repository\RestaurantRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MenuFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        DishRepository $dishRepository, 
        RestaurantRepository $restaurantRepository
    )
    {
        $this->dishRepository = $dishRepository;
        $this->restaurantRepository = $restaurantRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $restaurants = $this->restaurantRepository->findAll();

        $names = ['Formule du jour', 'Menu complet'];

        for ($i=0; $i < count($restaurants); $i++) { 
            $dishes = $this->dishRepository->findByRestaurant($restaurants[$i]);
            $total = 0;

            for ($j=0; $j < count($dishes); $j++) { 
                $total += round($dishes[$j]->getPrice() * 0.95, 2);
            }

            $menu = new Menu();

            $menu->setName($names[$i])
                ->setPrice($total)
                ->setRestaurant($restaurants[$i]);

            for ($k=0; $k < count($dishes); $k++) { 
                $menu->addDish($dishes[$k]);
            }

            $manager->persist($menu);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            RestaurantFixtures::class,
            DishFixtures::class,
        );
    }
}
