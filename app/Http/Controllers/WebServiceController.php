<?php

namespace App\Http\Controllers;

use App\Services\Zipper;
use ZipArchive;
use Google\Client;
use App\Models\Task;
use Google\Service\Drive;
use App\Models\WebService;
use Illuminate\Http\Request;
use App\Services\GoogleDrive;
use Google\Service\Drive\DriveFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class WebServiceController extends Controller
{
    public const DRIVE_SCOPES = [
        'https://www.googleapis.com/auth/drive.file',
        'https://www.googleapis.com/auth/drive'
    ];

    public function connect($web_service, Client $client)
    {
        if ($web_service === 'google-drive') {
            $client->addScope(self::DRIVE_SCOPES);
            $url = $client->createAuthUrl();
            return response(['url' => $url]);
        }
    }

    public function callback(Request $request, Client $client)
    {
        $token = $client->fetchAccessTokenWithAuthCode($request->code);
        $service = WebService::create([
            'user_id' => auth()->id(),
            'token' =>  $token,
            'name' => 'google-drive'
        ]);
        return $service;
    }

    public function upload(GoogleDrive $googleDrive, WebService $web_service, Client $client)
    {
        // get last 7 days tasks
        $tasks = Task::where('created_at', '>=', now()->subDays(7))->get();
        // create json file from extracted tasks
        $jsonFileName = 'tasks-json-dump.json';
        Storage::put('/public/temp/'.$jsonFileName, $tasks->toJson());
        
        // create a zip file and add json file to zip
        $zipFileName=Zipper::zip($jsonFileName);

        // send zip to drive 
        $googleDrive->upload($web_service->token['access-token'],$zipFileName);

        // clear temp dir
        Storage::deleteDirectory('/public/temp');

        return response('', Response::HTTP_CREATED);
    }
}