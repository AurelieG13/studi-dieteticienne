<?php

namespace App\DataFixtures;

use App\Entity\Allergy;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AllergyFixtures extends Fixture
{
    private $counter = 1;

    public function load(ObjectManager $manager): void
    {
        $this->createAllergy('Gluten', $manager);
        $this->createAllergy('Arachide', $manager);
        $this->createAllergy('Lait', $manager);
        $this->createAllergy('Oeufs', $manager);
        $this->createAllergy('Fruits à coque', $manager);
        $this->createAllergy('Mollusques', $manager);
        $this->createAllergy('Poissons', $manager);
        $this->createAllergy('Soja', $manager);
        $this->createAllergy('Sésame', $manager);

        $manager->flush();
    }

    public function createAllergy(string $name, ObjectManager $manager)
    {
        $allergy = new Allergy();
        $allergy->setName($name);
        $manager->persist($allergy);

        $this->addReference('all-'.$this->counter, $allergy);
        $this->counter++;

    }
}
