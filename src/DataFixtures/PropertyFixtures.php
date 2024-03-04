<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i=0; $i < 100; $i++) { 
            $property = new Property();
            $property
                ->setTitle($faker->words(3, true))
                ->setDescription($faker->words(30, true))
                ->setSurface($faker->numberBetween(10, 300))
                ->setRooms($faker->numberBetween(2, 10))
                ->setBedrooms($faker->numberBetween(5, 19))
                ->setFloor($faker->numberBetween(0, 15))
                ->setPrice($faker->numberBetween(10000, 550000))
                ->setCity($faker->city)
                ->setHeat($faker->numberBetween(0, count($property::HEAT) - 1))
                ->setPostalCode($faker->postcode)
                ->setAddress($faker->address)
                ->setSold(false)
                ;
            $manager->persist($property);
        }
        $manager->flush();
    }
}
