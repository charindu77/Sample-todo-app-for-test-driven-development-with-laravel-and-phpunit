<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use App\Http\Requests\RegisterRequest;

class RegistrationController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        $user=User::create($request->validated());
        return $user;
    }
}
