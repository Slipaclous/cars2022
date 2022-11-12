<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VentesController extends AbstractController
{
    #[Route('/ventes', name: 'ventespage')]
    public function index(): Response
    {
        return $this->render('ventes/index.html.twig', [
            'controller_name' => 'VentesController',
        ]);
    }
}
