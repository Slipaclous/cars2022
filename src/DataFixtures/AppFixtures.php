<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Marques;
use App\Entity\Voitures;
use App\Entity\Images;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    //gestion du hasher de password
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        
        $faker = Factory::create('fr_FR');

            //Création d'un admin
            $admin = new User();
            $admin->setEmail('admin@epse.be')
                ->setRoles(['ROLE_ADMIN'])
                ->setPassword($this->passwordHasher->hashPassword($admin,'password'));

            $manager->persist($admin);

            //Insertion des données pour les marques
            $marqueNom = array(
                'Audi' , 'BMW', 'Alfa Romeo', 'Fiat', 'Toyota', 'Seat', 'Volkswagen', 'Mercedes-Benz'
            );
            $marqueCover = array(
                'images/marqueImg/L_Audi.png', 'images/marqueImg/L_BMW.png', 'images/marqueImg/L_Alfa Romeo.png', 'images/marqueImg/L_Fiat.png', 'images/marqueImg/L_Toyota.png', 'images/marqueImg/L_Seat.png', 'images/marqueImg/L_Volkswagen.png', 'images/marqueImg/L_Mercedes-Benz.png',
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
                    ->setDescription(join( $faker->paragraphs(1)))
                    ->setOptionCar(join( $faker->paragraphs(1)))
                    ->setMarque($marque)
                    ->setcoverImg('cover.png');
                    for($j=1; $j<= rand(2,5); $j++)
                    {
                        $image = new Images();
                        $image->setLinkImg('https://picsum.photos/200/200')
                            ->setVoitures($voiture);
                        $manager->persist($image);    
                    }       

                    $manager->persist($voiture); 
        }  
          $manager->persist($marque); 
      }    
      $manager->flush();
        //Ajouter des voitures à la vente 
    }
}