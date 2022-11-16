<?php

namespace App\Controller;

use App\Entity\Marques;
use App\Entity\Voitures;
use App\Repository\MarquesRepository;
use App\Repository\VoituresRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(MarquesRepository $repo , VoituresRepository $repov): Response
    {
        $marque = $repo->findAll();
        

        return $this->render('home/index.html.twig', [
            'marques' => $marque,
           
        ]);
    }

    #[Route('/showall', name:'showall')]
    public function showAll(Request $request,MarquesRepository $repom,VoituresRepository $repov)
    {
       
        $marque = $repom->findAll();
        $voiture = $repov->findAll();

        return $this->render('home/allvoitures.html.twig', [
            'marques' => $marque,
            'voitures' => $voiture
           
        ]);
    }
}
