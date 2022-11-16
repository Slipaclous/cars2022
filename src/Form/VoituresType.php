<?php

namespace App\Form;

use App\Entity\Marques;
use App\Entity\Voitures;



use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class VoituresType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('modele', TextType::class,[
                'label'=>'Modèle',
                'attr'=>[
                    'placeholder'=>"Nom de votre modèle"
                ]
            ])
            ->add('slug', TextType::class, $this->getConfiguration('Slug', 'Adresse web (automatique)',[
                'required' => false
            ]))
            ->add('km',IntegerType::class , $this->getConfiguration("Kilométrage","ex:56877 "))
            ->add('prix',NumberType::class , $this->getConfiguration("Prix de la voiture","ex:9546,99"))
            ->add('cylindree',NumberType::class, $this->getConfiguration("Cylindrée","ex:1.8"))
            ->add('puissance',IntegerType::class,$this->getConfiguration("Nombre de Ch","ex:98"))
            ->add('carburant',TextType::class,$this->getConfiguration("Carburant","ex:esssence"))
            ->add('transmission',TextType::class,$this->getConfiguration("Transmission","ex:avant"))
            ->add('annee_circulation',DateType::class,$this->getConfiguration("Année de mise en circulation","ex:1988"))
            ->add('nb_proprio',IntegerType::class , $this->getConfiguration("Nombre de propriétaires précédent","ex:7"))
            ->add('description',TextareaType::class,$this->getConfiguration("Description","insérez un texte"))
            ->add('option_car',TextareaType::class,$this->getConfiguration("Options de la voiture","..."))
            ->add('coverImg', FileType::class, [
                'label'=>"Avatar(jpg,png,gif)",
                "required"=> false
            ])
            // ->add('marque',EntityType::class,[
            //     'class'=>Marques::class,
            //     'choice_label'=>'nom',
            //     'choice'=>Marques::fieldName($this,'nom')
                
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voitures::class,
        ]);
    }
}
