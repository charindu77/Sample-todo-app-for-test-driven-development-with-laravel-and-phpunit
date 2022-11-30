<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    public function __invoke(RegisterRequest $request):User
    {
        $user=User::create($request->validated());
        return $user;
    }
}
