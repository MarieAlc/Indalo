<?php

namespace App\Controller;

use App\Entity\Fabrication;
use App\Form\FabricationForm;
use App\Repository\FabricationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request as BrowserKitRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FabricationController extends AbstractController
{
    #[Route('/fabrication', name: 'app_fabrication')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $fabrications = $em->getRepository(Fabrication::class)->findAll();
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));

        $expiredFabricationsToShow = [];

        foreach ($fabrications as $fab) {
            $expirationDate = $fab->getDate()->modify('+' . $fab->getDureeConsomation()->getDuree() . ' hours');

            // Si le produit est expiré
            if ($expirationDate < $now) {
                // S’il n’est pas encore marqué visible, on le marque visible
                if (!$fab->isVisible()) {
                    $em->persist($fab);
                }

                // S’il est visible, on l’ajoute à la liste à afficher
                if ($fab->isVisible()) {
                    $expiredFabricationsToShow[] = $fab;
                }
            }
        }

        $em->flush(); // Appliquer les changements visibles=true

        return $this->render('fabrication/index.html.twig', [
            'expiredFabrications' => $expiredFabricationsToShow,
        ]);

    }

    #[Route('/fabrication/ajouter', name: 'app_fabrication_ajouter')]
    public function ajouter(Request $request, EntityManagerInterface $em): Response
    {
        $fabrication = new Fabrication();
        $form = $this->createForm(FabricationForm::class, $fabrication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fabrication->setDate(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
            $em->persist($fabrication);
            $em->flush();

            return $this->redirectToRoute('app_fabrication');
        }

        return $this->render('fabrication/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/fabrication/liste', name: 'app_fabrication_liste')]
    public function liste(FabricationRepository $repo): Response
    {
        $fabrications = $repo->findBy([], ['date' => 'DESC']); 

        return $this->render('fabrication/liste.html.twig', [
            'fabrications' => $fabrications,
        ]);
    }
    #[Route('/fabrication/masquer-expire/{id}', name: 'app_fabrication_masquer_expire', methods: ['POST'])]
    public function masquerExpire(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $fabrication = $em->getRepository(Fabrication::class)->find($id);

        if (!$fabrication) {
            throw $this->createNotFoundException('Fabrication non trouvée');
        }

        $submittedToken = $request->request->get('_token');

        if ($this->isCsrfTokenValid('masquer' . $id, $submittedToken)) {
            $fabrication->setVisible(false);
            $em->persist($fabrication);
            $em->flush();
        }

        return $this->redirectToRoute('app_fabrication');
    }
}
