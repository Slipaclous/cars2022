<?php

namespace App\Form;


use App\Entity\Marques;
use App\Entity\Voitures;



use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class VoituresModifyType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('modele', TextType::class,[
                'label'=>'Modèle :',
                'required' => false,

                'attr'=>[
                    'placeholder'=>"Nom de votre modèle"
                ]
            ])
            ->add('slug', TextType::class, $this->getConfiguration('Slug', 'Adresse web (automatique)',[
                'required' => false,
            ]))
            ->add('km',IntegerType::class , $this->getConfiguration("Kilométrage :","ex:56877 "),['required' => false])
            ->add('prix',NumberType::class , $this->getConfiguration("Prix de la voiture","ex:9546,99"),['required' => false])
            ->add('cylindree', ChoiceType::class, [
                'choices' => [
                    '1.6' =>'1.6',
                    '1.8' => '1.8',
                    '2.6' => '2.6',
                ],
                "attr" => [
                    'class' => 'form-control',
                ],
                "label" => "Cylindrée :",
                'required' => false,
            ])
            ->add('puissance',IntegerType::class,$this->getConfiguration("Nombre de Ch","ex:98"),['required' => false])
            ->add('carburant', ChoiceType::class, [
                'choices' => [
                    'Essence' =>'Essence',
                    'Diesel' => 'Diesel',
                    'Electrique'=>'Electrique'
                ],
                "attr" => [
                    'class' => 'form-control',
                ],
                "label" => "Carburant :",
                'required' => false,
            ])
            ->add('transmission', ChoiceType::class, [
                'choices' => [
                    'Avant' =>'avant',
                    'Arrière' => 'arrière',
                ],
                "attr" => [
                    'class' => 'form-control',
                ],
                "label" => "Transmission :",
                'required' => false,
            ])
            ->add('annee_circulation',DateType::class,$this->getConfiguration("Année de mise en circulation :","ex:1988",["widget"=>"single_text"]),['required' => false])
            ->add('nb_proprio',IntegerType::class , $this->getConfiguration("Nombre de propriétaires précédent :","ex:7"),['required' => false])
            ->add('description',TextareaType::class,$this->getConfiguration("Description :","insérez un texte"),['required' => false])
            ->add('option_car',TextareaType::class,$this->getConfiguration("Options de la voiture :","..."),['required' => false])
            ->add('marque',EntityType::class,[
                'class'=>Marques::class,
                'choice_label'=>'nom',
                'required' => false,
                
                
                
            ])
           
           
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voitures::class
        ]);
    }
}
