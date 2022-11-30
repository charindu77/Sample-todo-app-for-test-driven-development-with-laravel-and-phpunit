<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;

class GoogleDrive
{
    public function __construct(protected Client $client)
    {
    }
    public function upload($token,$zipFileName)
    {
        $accessToken = $token;
        $this->client->setAccessToken($accessToken);

        $service = new Drive($this->client);
        $file = new DriveFile();

        // We'll setup an empty 1MB file to upload.
        // $file->setName("Hello World!");
        $result2 = $service->files->create(
            $file,
            [
                'data' => file_get_contents($zipFileName),
                'mimeType' => 'application/octet-stream',
                'uploadType' => 'multipart'
            ]
        );
    }
}