<?php

namespace App\DataFixtures;

use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $generator = Faker\Factory::create('fr_FR');

        for ($i=0; $i <= 10; $i++){
            $wish = new Wish();

            $wish->setTitle($generator->sentence())
                ->setAuthor($generator->name())
                ->setDescription($generator->text())
                ->setIsPublished($generator->boolean())
                ->setDateCreated($generator->dateTime())
                ->setNote($generator->randomFloat())
                ->setCategory($generator->randomFloat(1, 1, 4));


            $manager->persist($wish);
        }

        $manager->flush();
    }
}
