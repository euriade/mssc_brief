<?php

namespace App\Controller;

use App\Entity\Brief;
use App\Form\BriefType;
use App\Repository\BriefRepository;
use App\Utils\AppUtils;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BriefController extends AbstractController
{
    #[Route('/briefs', name: 'app_brief')]
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
    public function download(Brief $brief): Response
    {
        $data = array();

        // Récupération des données de l'entité et stockage dans un tableau
        $data[] = array(
            'Nom du client' => $brief->getCustomerName(),
            'Prénom du client' => $brief->getCustomerLastname(),
            'Nom de la société' => $brief->getCompany(),
            'Téléphone de l\'entreprise' => $brief->getPhone(),
            'Email du contact' => $brief->getEmail(),
            'Typologie' => $brief->getType(),
            'Date de mise en ligne souhaitée' => $brief->getOnlineDate()->format('d/m/Y'),
            'Sites web' => $brief->getWebsite(),
            'Nom de domaine' => $brief->getDomain(),
            'À souscrire' => $brief->isDomainSuscribe(),
            'Existant' => $brief->isDomainExisting(),
            'Hébergeur' => $brief->getHost(),
            'Login' => $brief->getHostLogin(),
            'Mot de passe' => $brief->getHostPassword(),
            // TODO : get seulement selon la typologie
            'Choix du pack artisan' => $brief->getArtisan(),
            'Choix du pack avocat' => $brief->getAvocat(),
            'Devons-nous reprendre le logo existant' => $brief->isLogoReused(),
            'Devons-nous reprendre les contenus du site existant' => $brief->isContentReused(),
            'Avez-vous d\'autres contenus (texte et image) à nous fournir sur le site web' => $brief->isOtherData(),
            'Upload de fichiers' => $brief->getFilesUploaded(),
            'Informations complémentaires' => $brief->getMoreInformation(),

        );

        $response = new Response();
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="data.csv"');

        $handle = fopen('php://output', 'w');

        fputcsv($handle, array_keys($data[0]));

        foreach ($data as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        $response->send();

        return $this->redirectToRoute('subject_index');
    }

    /**
     * @Route("/briefs/{id}/file", name="brief_file")
     */
    public function showFile($id, ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $briefRepository = $entityManager->getRepository(Brief::class);
        $brief = $briefRepository->find($id);

        if (!$brief) {
            throw $this->createNotFoundException('Brief non trouvé');
        }

        $filePath = $this->getParameter('upload_directory') . '/' . $brief->getFilesUploaded();

        return new BinaryFileResponse($filePath);
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
