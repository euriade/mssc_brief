<?php

namespace App\Controller;

use Dompdf\Dompdf;
use App\Entity\Brief;
use App\Entity\Website;
use App\Form\BriefType;
use App\Utils\AppUtils;
use App\Repository\BriefRepository;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BriefController extends AbstractController
{
    /**
     * @Route("/briefs", name="app_brief")
     */
    public function index(ManagerRegistry $doctrine, Request $request, BriefRepository $briefRepository): Response
    {
        $entityManager = $doctrine->getManager();

        // Récupère tous les briefs de la BDD
        $repository = $doctrine->getRepository(Brief::class);
        $briefs = $repository->findAll();
        $badgeColors = $this->getBadgeColorForAllBriefs($briefs);

        // Formulaire de recherche de brief par nom de société
        $q = $request->request->get('q');

        if ($q && empty($status)) {
            $briefs = $briefRepository->findByCompany($q);
        } else {
            // Filtre les briefs par statut
            $status = $request->request->get('status');

            if (!empty($status)) {
                $briefs = $briefRepository->findByStatus($status);
            } else {
                $briefs = $briefRepository->findAll();
            }
        }

        $pageTitle = "Consulter un brief";

        return $this->render('brief/index.html.twig', [
            'briefs' => $briefs,
            'pageTitle' => $pageTitle,
            'badgeColors' => $badgeColors,
        ]);
    }

    /**
     * @Route("/briefs/create", name="brief_create")
     */
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {


        $brief = new Brief();
        $website = new Website();
        $brief->addWebsite($website);
        $form = $this->createForm(BriefType::class, $brief);
        $form->handleRequest($request);
        $pageTitle = "Créer un brief";

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $doctrine->getManager();
            // récupère l'entité associée au formulaire
            $file = $form->get('files_uploaded')->getData();

            if ($file) {
                $fileName = uniqid() . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
                $brief->setFilesUploaded($fileName);
            }


            // sauvegarde dans la BDD le brief et ses fichiers
            $entityManager->persist($brief);
            $entityManager->flush();

            // set website à ton brief
            /* $briefId = $brief->getId();
            $front = $request->request->get('test[]');
            $back = $request->request->get('test2[]');
            $login = $request->request->get('test3[]');
            $password = $request->request->get('test4[]');
            dump($back);
            die; */



            return $this->redirectToRoute('app_brief');
        } else {
            $formError = new FormError('Erreur de soumission du formulaire');
            $form->addError($formError);
        }

        // $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('brief/create.html.twig', [
            'briefForm' => $form->createView(),
            'pageTitle' => $pageTitle,
        ]);
    }

    /**
     * @Route("/briefs/{id}/edit", name="brief_edit")
     */
    public function edit(int $id, Request $request, Brief $brief, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $briefRepository = $entityManager->getRepository(Brief::class);
        $brief = $briefRepository->find($id);

        $form = $this->createForm(BriefType::class, $brief);
        $form->handleRequest($request);

        $pageTitle = "Éditer le brief " . $brief->getCompany();


        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $entityManager->persist($formData);
            $entityManager->flush();

            return $this->redirectToRoute('app_brief');
        }

        // $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('brief/edit.html.twig', [
            'brief' => $brief,
            'briefForm' => $form->createView(),
            'pageTitle' => $pageTitle,
        ]);
    }

    /**
     * @Route("/briefs/{id}/delete", name="brief_delete")
     */
    public function delete(Brief $brief, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($brief);
        $entityManager->flush();

        $this->addFlash('success', 'Le brief a été supprimé avec succès.');


        return $this->redirectToRoute('app_brief');
    }

    /**
     * @Route("/briefs/{id}", name="brief_show")
     */
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

    /**
     * @Route("/briefs/{id}/download", name="brief_download")
     */
    public function download(int $id, EntityManagerInterface $entityManager): Response
    {
        $brief = $entityManager->getRepository(Brief::class)->find($id);
        $pageTitle = 'Télécharger en format PDF';
        $badgeColor = AppUtils::getBadgeColor($brief->getStatus());

        if (!$brief) {
            throw $this->createNotFoundException('Le brief demandé n\'existe pas.');
        }

        $html = $this->renderView('brief/show.html.twig', [
            'brief' => $brief,
            'pageTitle' => $pageTitle,
            'badgeColor' => $badgeColor,
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
}
