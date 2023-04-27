<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        $pageTitle = "Que souhaitez-vous faire ?";

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'pageTitle' => $pageTitle,
        ]);
    }
}
