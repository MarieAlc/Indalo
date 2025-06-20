<?php

namespace App\Controller;

use App\Entity\NettoyageEffectue;
use App\Entity\PlanNettoyage;
use App\Repository\NettoyageEffectueRepository;
use App\Repository\PlanNettoyageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PlanNettoyageRepository $planNettoyageRepository, EntityManagerInterface $entityManager): Response
    { 
        $planNettoyageRepo = $entityManager->getRepository(PlanNettoyage::class);
        $nettoyageEffectueRepo = $entityManager->getRepository(NettoyageEffectue::class);

        $plans = $planNettoyageRepo->findAll();
        $today = new \DateTimeImmutable();
        $nonValides = [];

        foreach ($plans as $plan) {
            $dernierNettoyage = $nettoyageEffectueRepo->findOneBy(
                ['planNettoyage' => $plan],
                ['date' => 'DESC']
            );

            $interval = $plan->getReccurence()->getIntervalleJour();

            if ($dernierNettoyage) {
                $dateDerniereValidation = $dernierNettoyage->getDate();
                $dateProchaineValidation = $dateDerniereValidation->modify("+{$interval} days");

                if ($today >= $dateProchaineValidation) {
                    $nonValides[] = [
                        'plan' => $plan,
                        'dateDerniereValidation' => $dateDerniereValidation,
                    ];
                }
            } else {
                $nonValides[] = [
                    'plan' => $plan,
                    'dateDerniereValidation' => null,
                ];
            }
        }

        return $this->render('home/index.html.twig', [
            'nonValides' => $nonValides,
        ]);
    }
}
   

