<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $ingredients = ['Oeuf', 'Farine', 'Lait', 'Sucre', 'Beurre', 'Viande', 'Poisson', 'Légume', 'Féculents'];

        for ($i=0; $i < count($ingredients); $i++) { 
            $ingredient = new Ingredient();

            $ingredient->setName($ingredients[$i]);

            $manager->persist($ingredient);
        }

        $manager->flush();
    }
}
