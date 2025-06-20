<?php

namespace App\Controller;

use App\Entity\NettoyageEffectue;
use App\Entity\PlanNettoyage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class NettoyageController extends AbstractController
{
    #[Route('/nettoyage', name: 'app_nettoyage', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $planNettoyageRepo = $entityManager->getRepository(PlanNettoyage::class);
        $nettoyageEffectueRepo = $entityManager->getRepository(NettoyageEffectue::class);

        $plans = $planNettoyageRepo->findAll();
        $today = new \DateTimeImmutable();

        $valides = [];
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
                } else {
                    $valides[] = [
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
        $dernieresValidations = $entityManager->getRepository(NettoyageEffectue::class)
            ->createQueryBuilder('n')
            ->orderBy('n.date', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

        return $this->render('nettoyage/index.html.twig', [
            'valides' => $valides,
            'nonValides' => $nonValides,
            'validations' => $dernieresValidations,
        ]);
    }

    #[Route('/nettoyage/liste', name: 'app_nettoyage_liste')]
    public function historique(EntityManagerInterface $em): Response
    {
        $taches = $em->getRepository(NettoyageEffectue::class)->findBy([], ['date' => 'DESC']);

        return $this->render('nettoyage/liste.html.twig', [
            'taches' => $taches,
        ]);
    }



    #[Route('/nettoyage/valider', name: 'app_nettoyage_valider', methods: ['GET'])]
    public function valider(EntityManagerInterface $entityManager): Response
    {
        $planNettoyageRepo = $entityManager->getRepository(PlanNettoyage::class);
        $nettoyageEffectueRepo = $entityManager->getRepository(NettoyageEffectue::class);

        $plansValides = $planNettoyageRepo->findBy(['valide' => true]);
        $today = new \DateTimeImmutable();
        $tachesAValider = [];

        foreach ($plansValides as $plan) {
            $dernierNettoyage = $nettoyageEffectueRepo->findOneBy(
                ['planNettoyage' => $plan],
                ['date' => 'DESC']
            );

            if ($dernierNettoyage) {
                $dateDerniereValidation = $dernierNettoyage->getDate();
                $interval = $plan->getReccurence()->getIntervalleJour();
                $dateProchaineValidation = $dateDerniereValidation->modify("+{$interval} days");

                if ($today >= $dateProchaineValidation) {
                    $tachesAValider[] = [
                        'plan' => $plan,
                        'dateProchaineValidation' => $dateProchaineValidation,
                    ];
                }
            } else {
                $tachesAValider[] = [
                    'plan' => $plan,
                    'dateProchaineValidation' => null,
                ];
            }
        }

        return $this->render('nettoyage/valider.html.twig', [
            'nonValides' => $tachesAValider,
        ]);
    }

    #[Route('/nettoyage/valider/traiter', name: 'app_nettoyage_valider_traiter', methods: ['POST'])]
    public function validerTaches(Request $request, EntityManagerInterface $em): Response
    {
        $ids = $request->request->all('plan_ids');

        if (!is_array($ids) || empty($ids)) {
            $this->addFlash('warning', 'Aucune tâche sélectionnée.');
            return $this->redirectToRoute('app_nettoyage_valider');
        }

        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('danger', 'Vous devez être connecté pour valider une tâche.');
            return $this->redirectToRoute('app_login');
        }

        $planRepo = $em->getRepository(PlanNettoyage::class);
        $nettoyageRepo = $em->getRepository(NettoyageEffectue::class);
        $today = new \DateTimeImmutable();

        foreach ($ids as $planId) {
            $plan = $planRepo->find($planId);
            if (!$plan) continue;

            // Vérifie s'il a déjà été validé aujourd'hui
            $dejaFait = $nettoyageRepo->findOneBy([
                'planNettoyage' => $plan,
                'date' => $today,
            ]);

            if ($dejaFait) {
                $this->addFlash('info', sprintf("La tâche '%s' a déjà été validée aujourd'hui.", $plan->getNom()));
                continue;
            }

            $effectue = new NettoyageEffectue();
            $effectue->setDate($today);
            $effectue->setUtilisateur($user);
            $effectue->setPlanNettoyage($plan);

            $em->persist($effectue);
        }

        $em->flush();

        $this->addFlash('success', 'Les tâches ont été validées avec succès.');
        return $this->redirectToRoute('app_nettoyage');
    }
}
