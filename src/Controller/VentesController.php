<?php

namespace App\Controller;

use App\Entity\Marques;
use App\Entity\Voitures;
use App\Form\VoituresType;
use App\Repository\MarquesRepository;
use App\Repository\VoituresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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

    #[Route("/ventes/new", name:"ventes_new")]
    #[IsGranted("ROLE_ADMIN")]
    public function create(Request $request,EntityManagerInterface $manager, MarquesRepository $repom,Marques $marques): Response
    {
      $newVoiture = new Voitures();  
      $form = $this->createForm(VoituresType::class, $newVoiture);
      $form->handleRequest($request);
      $manager->persist($newVoiture);
      $manager->flush();

        $this->addFlash(
            'success',
            "L'annonce <strong>{$newVoiture->getModele()}</strong> a bien été enregistrée!"
        );
  
    return $this->redirectToRoute('ventes/new.html.twig', [
        'slug' => $newVoiture->getSlug(),
        // 'marques'=>$marques
    ]);
    }

    #[Route('/ventes/{slug}', name:'ventes_show')]
    public function show(string $slug, Voitures $voiture):Response
    {
        // dump($ad);

        return $this->render('ventes/show.html.twig',[
            'voiture' => $voiture
        ]);
    }
}