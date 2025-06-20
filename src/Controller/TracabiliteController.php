<?php

namespace App\Controller;

use App\Entity\Tracabilite;
use App\Form\TracabiliteForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\Exception\NoFileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

final class TracabiliteController extends AbstractController
{
    #[Route('/tracabilite', name: 'app_tracabilite')]
    public function index(): Response
    {
        return $this->render('tracabilite/index.html.twig', [
            'controller_name' => 'TracabiliteController',
        ]);
    }

    #[Route('/tracabilite/ajouter', name: 'app_tracabilite_ajouter')]
    public function ajouter(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response{

        $tracabilite = new Tracabilite();

        $form = $this->createForm(TracabiliteForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tracabilite = $form->getData();
            $em->persist($tracabilite);
            $em->flush();

            $photoFile = $form->get('photo')->getData();
            if ($photoFile) {
                $originalFileName = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFileName = $slugger->slug($originalFileName);
                $newFileName = $safeFileName.'-'.uniqid().'.'.$photoFile->guessExtension();
                try{
                    $photoFile->move(
                        $this->getParameter('photos_directory'),
                        $newFileName
                    );
                }catch (FileException $e) {
                    throw new \Exception('Erreur lors de l\'upload de l\'image.');
                }
                
                
                $tracabilite->setPhoto($newFileName);
            }
            $em->persist($tracabilite);
            $em->flush();
            $this->addFlash('success', 'Traçabilité ajoutée avec succès !');

            return $this->redirectToRoute('app_tracabilite');
        }
        
        return $this->render('tracabilite/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/tracabilite/liste', name: 'app_tracabilite_liste')]
    public function liste(EntityManagerInterface $em): Response{

        $tracabilites = $em->getRepository(Tracabilite::class)->findBy([], ['date' => 'DESC']);

        return $this->render('tracabilite/liste.html.twig', [
            'tracabilites' => $tracabilites,
        ]);
    }
}
