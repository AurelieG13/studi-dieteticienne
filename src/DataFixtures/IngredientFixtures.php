<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($foring = 0; $foring < 50; $foring++) {
            $ingredient = new Ingredient();
            $ingredient->setName('ingredient '.$foring);
            $ingredient->setQuantity(rand(1, 10));

            //ref ingredient
            $this->setReference('ing-'.$foring, $ingredient);

            $manager->persist($ingredient);
            }
    
            $manager->flush();
    }
}
