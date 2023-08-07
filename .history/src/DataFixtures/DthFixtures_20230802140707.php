<?php
// src/DataFixtures/AppFixtures.php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\CollectionCenter;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $centersData = [
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
                [
                    'name' => 'Maison du Don Toulouse',
                    'image' => 'center4.jpg',
                    'address' => '8 Allée Jules Guesde',
                    'postalCode' => 31000,
                    'city' => 'Toulouse',
                    'availableSeats' => 100,
                ],
                [
                    'name' => 'Association Main Tendue',
                    'image' => 'center5.jpg',
                    'address' => '14 Rue de la Liberté',
                    'postalCode' => 06000,
                    'city' => 'Nice',
                    'availableSeats' => 100,
                ],
                [
                    'name' => 'Centre d\'Aide et de Solidarité',
                    'image' => 'center6.jpg',
                    'address' => '3 Rue de la Paix',
                    'postalCode' => 44000,
                    'city' => 'Nantes',
                    'availableSeats' => 100,
                ],
                [
                    'name' => 'Fondation Espoir et Partage',
                    'image' => 'center7.jpg',
                    'address' => '45 Rue de la Cathédrale',
                    'postalCode' => 67000,
                    'city' => 'Strasbourg',
                    'availableSeats' => 100,
                ],
                [
                    'name' => 'Maison de l\'Espérance',
                    'image' => 'center8.jpg',
                    'address' => '18 Rue Foch',
                    'postalCode' => 34000,
                    'city' => 'Montpellier',
                    'availableSeats' => 100,
                ],
                [
                    'name' => 'Centre Solidaire de Bordeaux',
                    'image' => 'center9.jpg',
                    'address' => '9 Place des Quinconces',
                    'postalCode' => 33000,
                    'city' => 'Bordeaux',
                    'availableSeats' => 100,
                ],
                [
                    'name' => 'L\'Étoile du Partage',
                    'image' => 'center10.jpg',
                    'address' => '22 Rue de Paris',
                    'postalCode' => 59000,
                    'city' => 'Lille',
                    'availableSeats' => 100,
                ],
                [
                    'name' => 'Centre de Don de Rennes',
                    'image' => 'center11.jpg',
                    'address' => '5 Rue Saint-Georges',
                    'postalCode' => 35000,
                    'city' => 'Rennes',
                    'availableSeats' => 100,
                ],
                [
                    'name' => 'Association Don et Partage',
                    'image' => 'center12.jpg',
                    'address' => '11 Avenue de Laon',
                    'postalCode' => 51100,
                    'city' => 'Reims',
                    'availableSeats' => 100,
                ],
                [
                    'name' => 'Maison de l\'Entraide',
                    'image' => 'center13.jpg',
                    'address' => '30 Rue du Peuple',
                    'postalCode' => 42000,
                    'city' => 'Saint-Étienne',
                    'availableSeats' => 100,
                ],
                [
                    'name' => 'Centre d\'Aide aux Plus Démunis',
                    'image' => 'center14.jpg',
                    'address' => '7 Rue du Général Sarrail',
                    'postalCode' => 76600,
                    'city' => 'Le Havre',
                    'availableSeats' => 100,
                ],
                [
                    'name' => 'Solidarité Toulonnaise',
                    'image' => 'center15.jpg',
                    'address' => '12 Avenue de la République',
                    'postalCode' => 83000,
                    'city' => 'Toulon',
                    'availableSeats' => 100,
                ];
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
