<?php

namespace App\DataFixtures;

use App\Entity\Diet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DietFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($fordiet = 1; $fordiet < 10; $fordiet++) {
            $diet = new Diet();
            $diet->setName('RegimeType '.$fordiet);
    
            //ref diet
            $this->setReference('diet-'.$fordiet, $diet);
    
            $manager->persist($diet);
            }
    
            $manager->flush();
    }
}
