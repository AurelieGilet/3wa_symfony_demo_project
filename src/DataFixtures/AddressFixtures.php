<?php

namespace App\DataFixtures;

use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AddressFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $cities = ['Paris', 'Le Mont-Saint-Michel'];
        $zips = ['75005', '50170'];
        $streets = ['17 Quai de la Tournelle', '18 Grande Rue'];

        for ($i=0; $i < count($cities); $i++) { 
            $address = new Address();

            $address->setCity($cities[$i])
                ->setZip($zips[$i])
                ->setStreet($streets[$i])
            ;

            $manager->persist($address);
        }
        
        $manager->flush();
    }
}
