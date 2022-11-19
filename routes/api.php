<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\WebServiceController;
use App\Http\Controllers\ToDoListController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('todo-list',ToDoListController::class);
    
    Route::apiResource('todo-list.task',TaskController::class)
        ->except('show')
        ->shallow();

    Route::apiResource('label',LabelController::class);

    Route::get('/web-service/connect/{web_service}',[WebServiceController::class,'connect'])
        ->name('service.connect');

    Route::post('/web-service/callback',[WebServiceController::class,'callback'])
        ->name('service.callback');
});

Route::post('/register',RegistrationController::class)
    ->name('user.register');

Route::post('/login',LoginController::class)
    ->name('user.login');

