<?php

namespace App\Controller;

use App\Repository\VoituresRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VentesController extends AbstractController
{
    #[Route('/ventes', name: 'ventespage')]
    public function index(VoituresRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $voiture = $paginator->paginate(
            $repo->findAll(),
            $request->query->getInt('page',1),15
        );

        return $this->render('ventes/index.html.twig', [
            
            'voiture' => $voiture,
        ]);
    }
}