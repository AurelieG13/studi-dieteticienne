<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RecipeFixtures extends Fixture
{
    private $counter = 1;

    public function load(ObjectManager $manager): void
    {

        for ($rcp = 0; $rcp < 50; $rcp++) {
        $recipe = new Recipe();
        $recipe->setTitle('Nom de la recette '.$rcp);
        $recipe->setDescription('Description de la recette '.$rcp);
        $recipe->setPrepareTime(new \DateTime('00:10:00'));
        $recipe->setRestTime(new \DateTime('00:10:00'));
        $recipe->setCookingTime(new \DateTime('00:10:00'));
        $recipe->setActiveRecipe(false);

        //allergy
        $allergy = $this->getReference('all-'. rand(1, 4));
        $recipe->addAllergy($allergy);

        //ingredients
        $ingredient = $this->getReference('ing-'. rand(1, 4));
        $recipe->addIngredient($ingredient);

        //diet
        $diet = $this->getReference('diet-'. rand(1, 4));
        $recipe->addDiet($diet);

        // //step
        // $step = $this->getReference('step-'. rand(1, 4));
        // $recipe->addStep($step);

        // //rating
        // $rating = $this->getReference('rating-'. rand(1, 4));
        // $recipe->addRating($rating);

        $manager->persist($recipe);
        }

        //ref recipe
        $this->setReference('recipe-'.$rcp, $recipe);
        $this->counter++;

        $manager->flush();
    }
}
