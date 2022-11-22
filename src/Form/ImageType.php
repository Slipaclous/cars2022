<?php

namespace App\Form;


use App\Entity\Images;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class ImageType extends AbstractType
{
    /**
     * Extension du formulaire d'ajout pour les images de la voiture
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('linkImg', UrlType::class,[
                
                'attr' => [
                    'placeholder' =>"URL de"
                ]
            ])
           
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Images::class
        ]);
    }
}
