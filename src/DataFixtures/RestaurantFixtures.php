<?php

namespace App\DataFixtures;

use App\Entity\Restaurant;
use App\DataFixtures\AddressFixtures;
use App\Repository\AddressRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class RestaurantFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        AddressRepository $addressRepository, 
    )
    {
        $this->addressRepository = $addressRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $addresses = $this->addressRepository->findAll();

        $names = ['La Tour d\'Argent', 'La Mère Poulard'];
        $directors = ['André Terrail', 'Annette Poulard'];

        for ($i=0; $i < count($names); $i++) { 
            $restaurant = new Restaurant();

            $restaurant->setName($names[$i])
                ->setDirector($directors[$i])
                ->setAddress($addresses[$i])
            ;

            $manager->persist($restaurant);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            AddressFixtures::class,
        );
    }
}
