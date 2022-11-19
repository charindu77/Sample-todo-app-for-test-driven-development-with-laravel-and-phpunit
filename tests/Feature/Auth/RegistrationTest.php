<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
use RefreshDatabase;
    public function test_a_user_cam_register()
    {
        $this->withExceptionHandling();
        
        $this->postJson(route('user.register'),[
            'name'=>'hon doe',
            'email'=>'charindu@cjcreation.com',
            'password'=>'password123',
            'password_confirmation'=>'password123'
        ])
        ->assertCreated();
    } 
}
