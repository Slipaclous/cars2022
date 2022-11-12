<?php

namespace App\DataFixtures;

use App\Entity\Marques;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        
    
            $marqueNom = array(
                'audi' , 'BMW', 'Alfa Romeo', 'Fiat', 'Toyota', 'Seat', 'Volkswagen', 'Mercedes-Benz'
            );
            $marqueCover = array(
                'build/images/L_Audi.png', 'build/images/L_BMW.png', 'build/images/L_Alfa Romeo.png', 'build/images/L_Fiat.png', 'build/images/L_Toyota.png', 'build/images/L_Seat.png', 'build/images/L_Volkswagen.png', 'build/images/L_Mercedes-Benz.png',
            );
        
        
        for ($i=0; $i < 8 ; $i++) { 
            $marque = new Marques();
            $marque->setNom($marqueNom[$i])
                ->setCover($marqueCover[$i]);

        $manager->persist($marque);
        }
        

        $manager->flush();
    }
}