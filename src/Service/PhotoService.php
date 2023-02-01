<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhotoService
{
    private string $uploadDir;

    public function __construct(string $uploadDir)
    {
        $this->uploadDir = $uploadDir;
    }

    public function upload(UploadedFile $file): string
    {
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();

        if (!is_dir($this->uploadDir)) {
           mkdir($this->uploadDir);
        }

        $file->move(
            $this->uploadDir,
            $fileName
        );

        return $fileName;
    }
}