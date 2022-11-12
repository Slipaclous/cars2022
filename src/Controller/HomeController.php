<?php

namespace App\Controller;

use App\Repository\MarquesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(MarquesRepository $repo): Response
    {
        $marque = $repo->findAll();

        return $this->render('home/index.html.twig', [
            'marques' => $marque,
        ]);
    }
}
