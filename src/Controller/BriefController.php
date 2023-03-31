<?php

namespace App\Controller;

use App\Entity\Brief;
use App\Form\BriefType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class BriefController extends AbstractController
{
    #[Route('/briefs', name: 'app_brief')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Brief::class);
        $briefs = $repository->findAll();
        $pageTitle = "Consulter un brief";
        return $this->render('brief/index.html.twig', [
            'briefs' => $briefs,
            'pageTitle' => $pageTitle,
        ]);
    }

    /**
     * @Route("/briefs/create", name="brief_create")
     */
    public function create(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        $entityManager = $doctrine->getManager();
        $brief = new Brief();
        $form = $this->createForm(BriefType::class, $brief);
        $form->handleRequest($request);
        $pageTitle = "Créer un brief";

        if ($form->isSubmitted() && $form->isValid()) {

            // récupère l'entité associée au formulaire
            $file = $form->get('files_uploaded')->getData();

            if ($file) {
                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFileName);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('file_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception
                }

                // met à jour la propriété 'filesUploaded' pour conserver le nom du 
                // fichier et non son contenu
                $brief->setFilesUploaded($newFilename);
            }


            // sauvegarde dans la BDD le brief et ses fichiers
            $entityManager->persist($brief);
            $entityManager->flush();

            return $this->redirectToRoute('app_brief');
        }

        return $this->render('brief/create.html.twig', [
            'briefForm' => $form->createView(),
            'pageTitle' => $pageTitle,
        ]);
    }

    /**
     * @Route("/briefs/{id}/edit", name="brief_edit")
     */
    public function edit(Request $request, Brief $brief, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(BriefType::class, $brief);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($brief);
            $entityManager->flush();

            return $this->redirectToRoute('brief_index');
        }

        return $this->render('brief/edit.html.twig', [
            'brief' => $brief,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/briefs/{id}/delete", name="brief_delete")
     */
    public function delete(Request $request, Brief $brief, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        if ($this->isCsrfTokenValid('delete' . $brief->getId(), $request->request->get('_token'))) {
            $entityManager->remove($brief);
            $entityManager->flush();
        }

        return $this->redirectToRoute('brief_index');
    }

    /**
     * @Route("/briefs/{id}", name="brief")
     */
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        $briefRepository = $entityManager->getRepository(Brief::class);
        $brief = $briefRepository->find($id);

        if (!$brief) {
            throw $this->createNotFoundException('Brief non trouvé');
        }

        return $this->render('brief/show.html.twig', [
            'brief' => $brief,
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
            'Accès front' => $brief->getFrontAccess(),
            'Accès back-office' => $brief->getBackAccess(),
            'Login' => $brief->getWebsiteLogin(),
            'Mot de passe' => $brief->getWebsitePassword(),
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
}
