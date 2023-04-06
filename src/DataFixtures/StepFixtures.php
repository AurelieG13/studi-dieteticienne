<?php

namespace App\DataFixtures;

use App\Entity\Diet;
use App\Entity\Step;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StepFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($forstep = 1; $forstep < 10; $forstep++) {
            $step = new Step();
            $step->setName('Etape '.$forstep);
            $step->setDescription('Description '.$forstep);
    
            //ref step
            $this->setReference('step-'.$forstep, $step);
    
            $manager->persist($step);
            }
    
            $manager->flush();
    }
}
