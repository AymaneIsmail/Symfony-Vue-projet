<?php

namespace App\DataFixtures;

use App\Entity\Recette;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $recette = new Recette();
            $recette->setNom('Rectte numero : ' . $i);
            $recette->setIngredient('Ingredient : ' . $i);
            $manager->persist($recette);
        }

        $manager->flush();
    }
}
