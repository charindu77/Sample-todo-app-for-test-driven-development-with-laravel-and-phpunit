<?php

use Google\Client;
use Google\Service\Drive;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/google-drive',function(){
    $client=new Client();
    $client->setClientId('870034276614-1k83rna7a2clbm6n9jg86evo9ulsuvcj.apps.googleusercontent.com');
    $client->setClientSecret('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');
    $client->setRedirectUri('http://127.0.0.1:8000/google-drive/callback');
    $client->addScope([
        'https://www.googleapis.com/auth/drive.file',
        'https://www.googleapis.com/auth/drive'
    ]);

    $authUrl=$client->createAuthUrl();
    return redirect($authUrl);
});

Route::get('/google-drive/callback',function(){
    $code=request('code');

    $client=new Client();
    $client->setClientId('870034276614-1k83rna7a2clbm6n9jg86evo9ulsuvcj.apps.googleusercontent.com');
    $client->setClientSecret('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');
    $client->setRedirectUri('http://127.0.0.1:8000/google-drive/callback');

    $token=$client->fetchAccessTokenWithAuthCode($code);
    return $token;
});


Route::get('/upload',function(){
    $accessToken='ya29.a0AeTM1ieFkKac1CcUP7k_uiAzPw-LcHeyNtzvM9JqoG2kJjDKaoY-dlFGVoLsUt45D7SOK0IDBnQzCwfncP3mXSbLXazVcnkrsO_bGaGsJqHjbdAy5TSOijE9GKvLOkT9e07_8EoixupjYXhda8WKjlWWgYTLaCgYKAQcSARMSFQHWtWOm79O8kjwaVY3jKTj3G5oxZw0163';
    
    $client=new Client();
    $client->setClientId('870034276614-1k83rna7a2clbm6n9jg86evo9ulsuvcj.apps.googleusercontent.com');
    $client->setClientSecret('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');
    $client->setRedirectUri('http://127.0.0.1:8000/google-drive/callback');
    $client->setAccessToken($accessToken);

    $service= new Drive($client);
    $file = new Google\Service\Drive\DriveFile();

    // We'll setup an empty 1MB file to upload.
    DEFINE("TESTFILE", 'testfile-small.txt');
    if (!file_exists(TESTFILE)) {
        $fh = fopen(TESTFILE, 'w');
        fseek($fh, 1024 * 1024);
        fwrite($fh, "!", 1);
        fclose($fh);
    }

    $file->setName("Hello World!");
    $result2 = $service->files->create(
        $file,
        [
            'data' => file_get_contents(TESTFILE),
            'mimeType' => 'application/octet-stream',
            'uploadType' => 'multipart'
        ]   
    );


});
