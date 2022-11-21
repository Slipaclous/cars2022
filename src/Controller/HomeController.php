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
    /**
     * Permet d'afficher les marques
     *
     * @param MarquesRepository $repo
     * @param VoituresRepository $repov
     * @return Response
     */
    #[Route('/', name: 'homepage')]
    public function index(MarquesRepository $repo): Response
    {
        $marque = $repo->findAll();
        

        return $this->render('home/index.html.twig', [
            'marques' => $marque,
           
        ]);
    }
    /**
     * Permet d'afficher toutes les voitures d'une seule marque
     */
    #[Route('/marques/{id}', name: 'marques_show')]
    public function marquesShow(Marques $marques): Response
    {
        return $this->render('home/allvoitures.html.twig',[
            'marques' => $marques
        ]);
    }
    
}
