<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    #[Route(path: '/about', name: 'about')]
    public function index(): Response
    {
        $pageTitle = "À propos";

        return $this->render('about/index.html.twig', [
            'pageTitle' => $pageTitle,
        ]);
    }
}
