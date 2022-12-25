<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class Base64
{
    public static function getBase64ImageFromResources(string $fileName): string
    {
        $path = resource_path('img/' . $fileName);

        return self::getBase64String(File::mimeType($path), File::get($path));
    }

    public static function generateBase64String(UploadedFile $file): string
    {
        return self::getBase64String($file->getMimeType(), File::get($file->getPathname()));
    }

    private static function getBase64String(string $contentType, string $fileContents): string
    {
        return "data:{$contentType};base64," . base64_encode($fileContents);
    }
}
