<?php

namespace App\Controller;


use App\Entity\Voitures;
use App\Form\SearchType;
use App\Form\VoituresType;
use App\Form\VoituresModifyType;
use App\Entity\VoituresImgModify;
use App\Repository\ImagesRepository;
use App\Repository\VoituresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class VentesController extends AbstractController
{
    /**
     * Permet d'afficher les différentes voitures
     *
     * @param VoituresRepository $repo
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
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
    /**
     * Permet d'ajouter une nouvelle voiture
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
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
    /**
     * Permet de faire une recherche par mot clés
     *
     * @param Request $request
     * @param VoituresRepository $repov
     * @return void
     */
    #[Route('/ventes', name: 'ventespagesearch')]
    public function search(Request $request,VoituresRepository $repov)
    {
        $form = $this->createForm(SearchType::class);
        $search = $form->handleRequest($request);

        return $this->render('/ventes/index.html.twig',[
            'formsearch'=>$form->createView()
        ]);
    }
    /**
     * Permet de modifier une annonce de voiture
     */
    #[Route("/ventes/{slug}/edit", name:'voiture_edit')]
    #[Security("is_granted('ROLE_ADMIN')", message:"Cette annonce ne vous appartient pas, vous ne pouvez pas la modifier")]
    public function edit(Request $request, EntityManagerInterface $manager, Voitures $voitures):Response
    {
        $fileName = $voitures->getCoverImg();
        if(!empty($fileName))
        {
            new File($this->getParameter('uploads_directory').'/'.$voitures->getCoverImg());
        }

        $form = $this->createForm(VoituresModifyType::class, $voitures);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {           
                $voitures->setCoverImg($fileName);

                $voitures->setSlug('');
                $manager->persist($voitures);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "L'annonce <strong>{$voitures->getModele()}</strong> a bien été modifiée"
                );

                return $this->redirectToRoute('ventes_show',['slug'=>$voitures->getSlug()]);
        }


        return $this->renderForm("ventes/edit.html.twig",[
            
            "form" => $form,
            "voitures"=>$voitures
        ]);
    }
    /**
     * Permet d'afficher une voiture
     */
    #[Route('/ventes/{slug}', name:'ventes_show')]
    public function show(string $slug, Voitures $voiture,ImagesRepository $images):Response
    {
       $img = $images->findAll();
       

        return $this->render('ventes/show.html.twig',[
            'voiture' => $voiture,
            'images'=> $img
            
        ]);
    }
    /**
     * Permet de modifier l'image de la voiture
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    // #[Route("/account/imgmodify", name:"account_modifimg")]
    // #[IsGranted("ROLE_USER")]
    // public function imgModify(Request $request, EntityManagerInterface $manager): Response
    // {
    //     $imgModify = new VoituresImgModify();
    //     $voiture = $this->getVoitures(); 
    //     $form = $this->createForm(ImgModifyType::class, $imgModify);
    //     $form->handleRequest($request);

    //     if($form->isSubmitted() && $form->isValid())
    //     {
    //         // supprimer l'image dans le dossier
    //         if(!empty($voiture->getPicture()))
    //         {
    //             unlink($this->getParameter('uploads_directory').'/'.$voiture->getPicture());
    //         }

    //         $file = $form['newPicture']->getData();
    //         if(!empty($file))
    //         {
    //             $originalFilename = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
    //             $safeFilename = transliterator_transliterate('Any-Latin;Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
    //             $newFilename = $safeFilename."-".uniqid().".".$file->guessExtension();
    //             try{
    //                 $file->move(
    //                     $this->getParameter('uploads_directory'),
    //                     $newFilename
    //                 );
    //             }catch(FileException $e)
    //             {
    //                 return $e->getMessage();
    //             }
    //             $voiture->setPicture($newFilename);
    //         }

    //         $manager->persist($voiture);
    //         $manager->flush();

    //         $this->addFlash(
    //             'success',
    //             'Votre avatar a bien été modifié'
    //         );

    //         return $this->redirectToRoute('account_index');

    //     }

    //     return $this->render("account/imgModify.html.twig",[
    //         'myform' => $form->createView()
    //     ]);
    // }

    /**
     * Permet de supprimer une voiture
     */
    #[Route('/ventes/{slug}/delete', name:"voiture_delete")]
    #[Security("(is_granted('ROLE_ADMIN'))",message:'Cette voitures ne vous appartient pas')]
    public function delete(Voitures $voiture, EntityManagerInterface $manager): Response
    {
        if(!empty($voiture->getCoverImg()))
        {
            unlink($this->getParameter('uploads_directory').'/'.$voiture->getCoverImg());
            $voiture->setCoverImg('');

            
            
            $manager->flush();
           
        }
        
        foreach($voiture->getImages() as $image){
            
            $manager->remove($image);   
             
         }

        $this->addFlash(
            'success',
            "La voiture <strong>{$voiture->getModele()}</strong> a bien été supprimée"
        );

        $manager->remove($voiture);
        $manager->flush();

        return $this->redirectToRoute('ventespage');
    }
}