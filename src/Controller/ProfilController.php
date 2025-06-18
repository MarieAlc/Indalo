<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\ProfilInfosForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

final class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        $user = $this->getUser();

        return $this->render('profil/index.html.twig', [
            'user' => $user,
        ]);
    }
    #[Route('/profil/modifier', name: 'app_profil_modifier')]
    public function modifier(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfilInfosForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Informations mises à jour.');
            return $this->redirectToRoute('app_profil');
        }

        return $this->render('profil/modifier.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/profil/password', name: 'app_profil_password')]
    public function password(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

    // Sécurité : s'assurer que l'utilisateur est connecté
    if (!$user instanceof PasswordAuthenticatedUserInterface) {
        throw $this->createAccessDeniedException('Accès refusé.');
    }

    $form = $this->createForm(ChangePasswordFormType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $oldPassword = $form->get('oldPassword')->getData();

        if (!$passwordHasher->isPasswordValid($user, $oldPassword)) {
            $form->get('oldPassword')->addError(new \Symfony\Component\Form\FormError('Mot de passe actuel incorrect.'));
        } else {
            $newPassword = $form->get('newPassword')->getData();
            $hashed = $passwordHasher->hashPassword($user, $newPassword);
            $user->setPassword($hashed);
            $em->flush();

            $this->addFlash('success', 'Mot de passe modifié avec succès.');
            return $this->redirectToRoute('app_profil');
        }
    }

    return $this->render('profil/password.html.twig', [
        'form' => $form->createView(),
    ]);
    }

}
