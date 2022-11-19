<?php

namespace App\Http\Controllers;

use Google\Client;
use App\Models\WebService;
use Illuminate\Http\Request;

class  WebServiceController extends Controller
{
    public const DRIVE_SCOPES=[
        'https://www.googleapis.com/auth/drive.file',
        'https://www.googleapis.com/auth/drive'
    ];

    public function connect($web_service,Client $client)
    {
        if ($web_service === 'google-drive') {
            $client->addScope(self::DRIVE_SCOPES);
            $url = $client->createAuthUrl();
            return response(['url'=>$url]);
        }
    }

    public function callback(Request $request,Client $client)
    {
        $token=$client->fetchAccessTokenWithAuthCode($request->code);
        $service=WebService::create([
            'user_id'=> auth()->id(),
            'token'=> json_encode(['access-token'=>$token]),
            'name'=>'google-drive'
        ]);
        return $service;
    }
}