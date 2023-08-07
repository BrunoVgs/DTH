<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\CollectionCenter;

class DthFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $centersData = [
            [
                'name' => 'Centre de Dons Solidaires',
                'image' => 'center1.jpg',
                'address' => '123 Rue du Général Leclerc',
                'postalCode' => 75001,
                'city' => 'Paris',
                'availableSeats' => 100,
            ],
            [
                'name' => 'Association Don pour Tous',
                'image' => 'center2.jpg',
                'address' => '56 Avenue du Vieux-Port',
                'postalCode' => 13001,
                'city' => 'Marseille',
                'availableSeats' => 100,
            ],
            [
                'name' => 'Centre Caritatif Lyon Sud',
                'image' => 'center3.jpg',
                'address' => '27 Rue de la République',
                'postalCode' => 69001,
                'city' => 'Lyon',
                'availableSeats' => 100,
            ],
            // Ajoutez ici les autres centres de don avec leurs données respectives
            // ...
        ];

        foreach ($centersData as $centerData) {
            $center = new CollectionCenter();
            $center->setName($centerData['name']);
            $center->setImage($centerData['image']);
            $center->setAddress($centerData['address']);
            $center->setPostalCode($centerData['postalCode']);
            $center->setCity($centerData['city']);
            $center->setAvailableSeats($centerData['availableSeats']);

            $manager->persist($center);
        }

        $manager->flush();
    }
}
