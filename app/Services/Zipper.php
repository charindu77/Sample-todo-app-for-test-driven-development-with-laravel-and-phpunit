<?php

namespace App\Services;

use ZipArchive;

class Zipper
{
    public static function zip($fileName)
    {
        $zip = new ZipArchive();
        $zipFileName = storage_path('app/public/temp/' . now()->timestamp . '-task.zip');

        if ($zip->open($zipFileName,ZipArchive::CREATE) == true) {
            $zip->addFile(storage_path('app/public/temp/' . $fileName));
        }
        $zip->close();
        return $zipFileName;
    }
}
