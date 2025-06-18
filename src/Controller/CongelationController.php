<?php

namespace App\Controller;

use App\Form\CongelationForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CongelationController extends AbstractController
{
    #[Route('/congelation', name: 'app_congelation')]
    public function index(): Response
    {
        return $this->render('congelation/index.html.twig', [
            'controller_name' => 'CongelationController',
        ]);
    }

    #[Route('/congelation/ajouter', name: 'app_congelation_ajouter')]
    public function ajouter(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CongelationForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $congelation = $form->getData();
            $em->persist($congelation);
            $em->flush();

            $this->addFlash('success', 'Congélation ajoutée avec succès !');

            return $this->redirectToRoute('app_congelation');
        }
        
        return $this->render('congelation/ajouter.html.twig', [
            'form' => $form->createView(), 
        ]);
    }

    #[Route('/congelation/liste', name: 'app_congelation_liste')]
    public function liste(EntityManagerInterface $em): Response
    {
         $congelations = $em->getRepository('App\Entity\Congelation')->findBy([], ['date' => 'DESC']);

        return $this->render('congelation/liste.html.twig', [
            'congelations' => $congelations,
        ]);
}
}