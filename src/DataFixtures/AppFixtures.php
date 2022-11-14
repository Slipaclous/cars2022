<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Marques;
use App\Entity\Voitures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        
        $faker = Factory::create('fr_FR');
            $marqueNom = array(
                'audi' , 'BMW', 'Alfa Romeo', 'Fiat', 'Toyota', 'Seat', 'Volkswagen', 'Mercedes-Benz'
            );
            $marqueCover = array(
                'images/L_Audi.png', 'images/L_BMW.png', 'images/L_Alfa Romeo.png', 'images/L_Fiat.png', 'images/L_Toyota.png', 'images/L_Seat.png', 'images/L_Volkswagen.png', 'images/L_Mercedes-Benz.png',
            );
        
        // Permettra d'afficher les différentes marques
        for ($i=0; $i < 8 ; $i++) 
        { 
            $marque = new Marques();
            $marque->setNom($marqueNom[$i])
                ->setCover($marqueCover[$i]);
                
            
            

            
        
       
        for ($j=0; $j < rand(1,4);$j++ )
        {
           
           
            $voiture = new Voitures();
            $cylindreearay=['1.6','1.8','2.4'];
            $voiture-> setModele($faker->word())
                    ->setKm(rand(10000,100000))
                    ->setPrix(rand(5000,25000))
                    ->setCylindree($cylindreearay[array_rand($cylindreearay)])
                    ->setPuissance(rand(90,200))
                    ->setCarburant("Diesel")
                    ->setTransmission('arrière')
                    ->setAnneeCirculation( $faker->dateTimeBetween($startDate='-30years',$endDate='now'))
                    ->setNbProprio(rand(1,10))
                    ->setDescription('<p>'.join( $faker->paragraphs(1)).'</p>')
                    ->setOptionCar('<p>'.join( $faker->paragraphs(1)).'</p>')
                    ->setIdMarque($marque);

                    $manager->persist($voiture); 
        }  
          $manager->persist($marque); 
      }    
      $manager->flush();
        //Ajouter des voitures à la vente 
    }
}