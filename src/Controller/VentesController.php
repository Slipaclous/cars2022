<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Marques;
use App\Entity\Voitures;
use App\Form\SearchType;
use App\Form\VoituresType;
use App\Repository\ImagesRepository;
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
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
    public function create(Request $request,EntityManagerInterface $manager): Response
    {
      $voiture = new Voitures();  
      $form = $this->createForm(VoituresType::class, $voiture);
      $form->handleRequest($request);
    //   $manager->persist($voiture);
    //   $manager->flush();
       
        if($form->isSubmitted() && $form->isValid())
        {   
            dump((string) $form->getErrors(true, false));die;
            foreach($voiture->getImages() as $image){

               $image->setVoitures($voiture);
                $manager->persist($image);
                
            }

            $file = $form['coverImg']->getData();
            if(!empty($file))
            {
                $originalFilename = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin;Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename."-".uniqid().".".$file->guessExtension();
                try{
                    $file->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                }catch(FileException $e)
                {
                    return $e->getMessage();
                }
                $voiture->setCoverImg($newFilename);
            }
                // $cover->setCoverImg($voiture);
                // $manager->persist($cover);

            $manager->persist($voiture);
            $manager->flush();

            $this->addFlash(
                'success',
                "La voiture <strong>{$voiture->getModele()}</strong> a bien été enregistrée!"
            );

            return $this->redirectToRoute('ventes_show', [
                'slug' => $voiture->getSlug()
            ]);
        }
       
    return $this->renderForm('ventes/new.html.twig', [
        // 'hasError'=>$error !== null,
        
        'form' => $form
        
        
        
    ]);
    }

    #[Route('/ventes', name: 'ventespage')]
    public function search(Request $request,VoituresRepository $repov)
    {
        $form = $this->createForm(SearchType::class);
        $search = $form->handleRequest($request);

        return $this->render('/ventes/index.html.twig',[
            'formsearch'=>$form->createView()
        ]);
    }

    #[Route("/ventes/{slug}/edit", name:'voiture_edit')]
    #[Security("is_granted('ROLE_ADMIN')", message:"Cette annonce ne vous appartient pas, vous ne pouvez pas la modifier")]
    public function edit(Request $request, EntityManagerInterface $manager, Voitures $voitures):Response
    {
        $form = $this->createForm(VoituresType::class, $voitures);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            foreach($voitures->getImages() as $image)
            {
                $image->setVoitures($voitures);
                $manager->persist($image);
            }
            $file = $form['coverImg']->getData();
            if(!empty($file))
            {
                $originalFilename = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin;Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename."-".uniqid().".".$file->guessExtension();
                try{
                    $file->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                }catch(FileException $e)
                {
                    return $e->getMessage();
                }
                $voitures->setCoverImg($newFilename);
            }
                //$ad->setSlug("");

                $manager->persist($voitures);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "L'annonce <strong>{$voitures->getModele()}</strong> a bien été modifiée"
                );

                return $this->redirectToRoute('ventes_show',['slug'=>$voitures->getSlug()]);
        }


        return $this->renderForm("ventes/edit.html.twig",[
            
            "form" => $form
        ]);
    }

    #[Route('/ventes/{slug}', name:'ventes_show')]
    public function show(string $slug, Voitures $voiture,ImagesRepository $images):Response
    {
       $img = $images->findAll();
        // dump($ad);

        return $this->render('ventes/show.html.twig',[
            'voiture' => $voiture,
            'images'=> $img
            
        ]);
    }
}