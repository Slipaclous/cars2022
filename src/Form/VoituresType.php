<?php

namespace App\Form;

use App\Entity\Marques;
use App\Entity\Voitures;
use App\Entity\Images;



use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

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
            ->add('cylindree', ChoiceType::class, [
                'choices' => [
                    '1.6' =>'1.6',
                    '1.8' => '1.8',
                    '2.6' => '2.6',
                ],
                "attr" => [
                    'class' => 'form-control',
                ],
                "label" => "Cylindrée"
            ])
            ->add('puissance',IntegerType::class,$this->getConfiguration("Nombre de Ch","ex:98"))
            ->add('carburant', ChoiceType::class, [
                'choices' => [
                    'Essence' =>'Essence',
                    'Diesel' => 'Diesel',
                    'Electrique'=>'Electrique'
                ],
                "attr" => [
                    'class' => 'form-control',
                ],
                "label" => "Carburant"
            ])
            ->add('transmission', ChoiceType::class, [
                'choices' => [
                    'Avant' =>'avant',
                    'Arrière' => 'arrière',
                ],
                "attr" => [
                    'class' => 'form-control',
                ],
                "label" => "Transmission"
            ])
            ->add('annee_circulation',DateType::class,$this->getConfiguration("Année de mise en circulation","ex:1988",["widget"=>"single_text"]))
            ->add('nb_proprio',IntegerType::class , $this->getConfiguration("Nombre de propriétaires précédent","ex:7"))
            ->add('description',TextareaType::class,$this->getConfiguration("Description","insérez un texte"))
            ->add('option_car',TextareaType::class,$this->getConfiguration("Options de la voiture","..."))
            ->add('coverImg', FileType::class, [
                'label'=>"Avatar(jpg,png,gif)",
                "required"=> true
            ])
            ->add('marque',EntityType::class,[
                'class'=>Marques::class,
                'choice_label'=>'nom',
                
                
                
            ])
            ->add(
                'images',
                CollectionType::class,
                [
                    'entry_type' => ImageType::class,
                    'allow_add' => true, //Permet d'ajouter des éléments et surtout d'avoir data_prototype
                    'allow_delete' => true 
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voitures::class
        ]);
    }
}
