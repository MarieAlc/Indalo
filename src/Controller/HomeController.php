<?php

namespace App\Controller;

use App\Entity\NettoyageEffectue;
use App\Repository\NettoyageEffectueRepository;
use App\Repository\PlanNettoyageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PlanNettoyageRepository $planNettoyageRepository): Response
    {
        $tachesNonValidees = $planNettoyageRepository->findBy(['valide' => false]);
        
        return $this->render('home/index.html.twig', [
            'tachesNonValidees' => $tachesNonValidees,
        ]);

    }
}
