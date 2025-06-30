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
    public function index(PlanNettoyageRepository $planNettoyageRepository): Response
    {
        $today = new \DateTimeImmutable();
        $nonValides = [];

        $plans = $planNettoyageRepository->findPlansWithLastNettoyageAndReccurence();

        foreach ($plans as $result) {
            /** @var PlanNettoyage $plan */
            $plan = $result[0];
            $lastNettoyageDate = $result['lastNettoyageDate'] ?? null;

            if ($lastNettoyageDate !== null && ! $lastNettoyageDate instanceof \DateTimeImmutable) {
                $lastNettoyageDate = new \DateTimeImmutable($lastNettoyageDate);
            }

            $interval = $plan->getReccurence()->getIntervalleJour();

            if ($lastNettoyageDate) {
                $dateProchaineValidation = $lastNettoyageDate->modify("+{$interval} days");
                if ($today >= $dateProchaineValidation) {
                    $nonValides[] = [
                        'plan' => $plan,
                        'dateDerniereValidation' => $lastNettoyageDate,
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
   

