<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TemperatureController extends AbstractController
{
    #[Route('/temperature', name: 'app_temperature')]
    public function index(): Response
    {
        return $this->render('temperature/index.html.twig', [
            'controller_name' => 'TemperatureController',
        ]);
    }

    #[Route('/temperature/ajouter', name: 'app_temperature_ajouter')]
    public function ajouter(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm('App\Form\TemperatureForm');
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $temperature = $form->getData();
            $temperature->setDate(new \DateTimeImmutable());         
            $em->persist($temperature);
            $em->flush();

            $this->addFlash('success', 'Température ajoutée avec succès !');
            return $this->redirectToRoute('app_temperature');
        }
        return $this->render('temperature/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
        
    }

    #[Route('/temperature/liste', name: 'app_temperature_liste')]
    public function liste(EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository('App\Entity\Temperature');
        $temperatures = $repository->findAll();
        $temperatures = $repository->findBy([], ['date' => 'DESC']);
        $grouped = [];
        foreach ($temperatures as $temp) {
            $dateKey = $temp->getDate() ? $temp->getDate()->format('d/m/Y') : 'Date inconnue';
            $grouped[$dateKey][] = $temp;

        }
        krsort($grouped);

        return $this->render('temperature/liste.html.twig', [
            'temperatures' => $temperatures,
            'groupedTemperatures' => $grouped
        ]);
    }
}
