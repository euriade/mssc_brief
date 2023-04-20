<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{
    /**
     * @Route("/upload", name="upload")
     */
    public function add(Request $request): Response
    {
        $uploadedFiles = $request->files->all('files_uploaded');
        $destination = $this->getParameter('kernel.project_dir') . '/public/uploads';

        $uploadedFileNames = [];

        foreach ($uploadedFiles as $uploadedFile) {
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();

            $uploadedFile->move($destination, $newFilename);
            $uploadedFileNames[] = '/uploads/' . $newFilename;
        }

        return new Response(json_encode(['locations' => $uploadedFileNames]), 201);
    }
}
