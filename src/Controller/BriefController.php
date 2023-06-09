<?php

namespace App\Controller;

use App\Entity\Attachment;
use Dompdf\Dompdf;
use App\Entity\Brief;
use App\Entity\Domain;
use App\Entity\Website;
use App\Form\BriefType;
use App\Utils\AppUtils;
use App\Repository\BriefRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BriefController extends AbstractController
{


    #[Route(path: '/briefs', name: 'app_brief')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(Request $request, BriefRepository $briefRepository, PaginatorInterface $paginator): Response
    {
        // Récupère la recherche de la chaîne de requête
        $q = $request->query->get('q');
        $status = $request->query->get('status');

        if ($q) {
            $query = $briefRepository->findByCompany($q);
        } elseif ($status) {
            $query = $briefRepository->findByStatus($status);
        } else {
            $query = $briefRepository->paginationQuery();
        }

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        $badgeColors = $this->getBadgeColorForAllBriefs(iterator_to_array($pagination->getItems()));

        $pageTitle = "Consulter un brief";

        return $this->render('brief/index.html.twig', [
            'pageTitle' => $pageTitle,
            'badgeColors' => $badgeColors,
            'pagination' => $pagination,
        ]);
    }

    #[Route(path: '/briefs/create', name: 'brief_create')]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $brief = new Brief();
        $website = new Website();
        $domain = new Domain();
        $attachment = new Attachment();

        $brief->addWebsite($website);
        $brief->addDomain($domain);
        $brief->addAttachment($attachment);

        $form = $this->createForm(BriefType::class, $brief);
        $form->handleRequest($request);

        $pageTitle = "Créer un brief";

        $errors = [];

        if ($form->isSubmitted()) {

            if ($form->isValid()) {

                // Définit l'auteur du brief
                $brief->setCreatedBy($this->getUser());

                $entityManager = $doctrine->getManager();

                $entityManager->persist($brief);
                $entityManager->flush();

                return $this->redirectToRoute('app_brief');
            } else {
                $errors = $this->getErrorMessages($form);
            }
        }

        return $this->render('brief/create.html.twig', [
            'briefForm' => $form->createView(),
            'pageTitle' => $pageTitle,
            'errors' => $errors,
        ]);
    }

    #[Route(path: '/briefs/{id}/edit', name: 'brief_edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(int $id, Request $request, Brief $brief, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $briefRepository = $entityManager->getRepository(Brief::class);
        $brief = $briefRepository->find($id);

        $form = $this->createForm(BriefType::class, $brief);
        $form->handleRequest($request);

        $pageTitle = "Éditer le brief " . $brief->getCompany();

        $errors = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            $entityManager->persist($formData);
            $entityManager->flush();

            return $this->redirectToRoute('app_brief');
        } else {
            $errors = $this->getErrorMessages($form);
        }

        return $this->render('brief/edit.html.twig', [
            'brief' => $brief,
            'briefForm' => $form->createView(),
            'pageTitle' => $pageTitle,
            'errors' => $errors,
        ]);
    }

    #[Route(path: '/briefs/{id}/delete', name: 'brief_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Brief $brief, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($brief);
        $entityManager->flush();

        $this->addFlash('success', 'Le brief a été supprimé avec succès.');


        return $this->redirectToRoute('app_brief');
    }

    #[Route(path: '/briefs/{id}', name: 'brief_show')]
    #[IsGranted('ROLE_ADMIN')]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        $briefRepository = $entityManager->getRepository(Brief::class);
        $brief = $briefRepository->find($id);
        $pageTitle = "Brief " . $brief->getCompany();
        $badgeColor = AppUtils::getBadgeColor($brief->getStatus());

        if (!$brief) {
            throw $this->createNotFoundException('Brief non trouvé');
        }

        return $this->render('brief/show.html.twig', [
            'brief' => $brief,
            'pageTitle' => $pageTitle,
            'badgeColor' => $badgeColor,
        ]);
    }

    #[Route(path: '/briefs/{id}/download', name: 'brief_download')]
    #[IsGranted('ROLE_ADMIN')]
    public function download(int $id, EntityManagerInterface $entityManager): Response
    {
        $brief = $entityManager->getRepository(Brief::class)->find($id);
        $pageTitle = 'Télécharger en format PDF';

        if (!$brief) {
            throw $this->createNotFoundException('Le brief demandé n\'existe pas.');
        }

        $html = $this->renderView('brief/download.html.twig', [
            'brief' => $brief,
            'pageTitle' => $pageTitle,
        ]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();

        return new Response(
            $dompdf->output(),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }

    // Renvoie un tableau de la couleur du badge de chaque brief
    private function getBadgeColorForAllBriefs(array $briefs): array
    {
        $badgeColors = [];

        foreach ($briefs as $brief) {

            $badgeColors[$brief->getId()] = AppUtils::getBadgeColor($brief->getStatus());
        }

        return $badgeColors;
    }

    private function getErrorMessages(FormInterface $form)
    {
        $errors = [];

        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }

        return $errors;
    }
}
