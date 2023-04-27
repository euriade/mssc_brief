<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile/{id}', name: 'app_profile')]
    public function index(User $user, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine, Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('app_home');
        }

        $entityManager = $doctrine->getManager();

        $pageTitle = "Mon profil";

        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $form->get('password')->getData();
            if ($newPassword) {
                $user->setPassword($passwordHasher->hashPassword($user, $newPassword));
            }

            $user = $form->getData();

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Les informations de votre profil ont bien été modifiées');
            return $this->redirectToRoute('app_profile', ['id' => $user->getId()]);
        }

        return $this->render('profile/index.html.twig', [
            'pageTitle' => $pageTitle,
            'form' => $form->createView(),
        ]);
    }
}
