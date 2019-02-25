<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Property;
use Faker\Factory;

class PropertyFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {

         $faker = factory::create('fr_FR');

         for($i = 0;$i < 100; $i++) {
             $property = new Property();
             $property->setTitle($faker->words(3,true) )
                 ->setSurface($faker->numberBetween(50,350))
                 ->setPrice($faker->numberBetween(100000,350000))
                 ->setDescription($faker->sentences(3,true))
                 ->setRooms($faker->numberBetween(2,10))
                 ->setBedrooms($faker->numberBetween(1,9))
                 ->setPostalCode($faker->postcode)
                 ->setAddress($faker->address)
                 ->setCity($faker->city)
                 ->setHeat($faker->numberBetween(0,1))
                 ->setFloor($faker->numberBetween(0,15))
                 ->setSold(false);

             $manager->persist($property);
             $manager->flush();

         }

    }
}
