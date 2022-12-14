<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request):Response
    {
        $user=User::whereEmail($request->email)->first();

        if(!$user || !(Hash::check($request->password,$user->password))){
            return response('Credentials do not match.',Response::HTTP_UNAUTHORIZED);
        }
        
        $token=$user->createToken('api');
        return response(['token'=>$token->plainTextToken]);
    }
}
