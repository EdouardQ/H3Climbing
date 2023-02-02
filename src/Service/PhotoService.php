<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhotoService
{
    private string $uploadPublicDir;

    public function __construct(string $uploadPublicDir)
    {
        $this->uploadPublicDir = $uploadPublicDir;
    }

    public function upload(UploadedFile $file): string
    {
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();

        if (!is_dir($this->uploadPublicDir)) {
           mkdir($this->uploadPublicDir);
        }

        $file->move(
            $this->uploadPublicDir,
            $fileName
        );

        return $fileName;
    }
}