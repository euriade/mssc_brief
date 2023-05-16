<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class FilesUploaderService
{
    private $destination;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->destination = $parameterBag->get('files_directory');
    }

    public function upload(array $files): array
    {

        $newFilenames = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $slugger = new AsciiSlugger();
                $newFilename = $slugger->slug($originalFilename) . '-' . uniqid() . '.' . $file->guessExtension();
                $file->move($this->destination, $newFilename);

                $newFilenames[] = $newFilename;
            }
        }

        return $newFilenames;
    }
}
