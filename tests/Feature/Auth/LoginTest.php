<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Symfony\Component\Routing\Route;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{

    use RefreshDatabase;
    public function test_user_can_login_with_email_and_password()
    {
        $user=$this->createUser();
        $response = $this->postJson(Route('user.login'),[
            'email'=>$user->email,
            'password'=>'password'
        ])
        ->assertOk();

        $this->assertArrayHasKey('token',$response->json());
    }

    public function test_user_can_not_login_when_email_does_not_exist()
    {
        $this->postJson(Route('user.login'),[
            'email'=>'charindu@cjcreation.com',
            'password'=>'password123'
        ])
        ->assertUnauthorized();

    }

    public function test_user_can_not_login_when_password_does_not_match()
    {
        $user=$this->createUser();
        $response = $this->postJson(Route('user.login'),[
            'email'=>$user->email,
            'password'=>'password123'
        ])
        ->assertUnauthorized();

    }
}
