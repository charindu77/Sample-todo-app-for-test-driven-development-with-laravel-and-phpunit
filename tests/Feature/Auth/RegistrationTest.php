<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
use RefreshDatabase;
    public function test_a_user_can_register()
    {
        $this->withExceptionHandling();
        
        $user=$this->postJson(route('user.register'),[
            'name'=>'jon doe',
            'email'=>'charindu@cjcreation.com',
            'password'=>'password123',
            'password_confirmation'=>'password123'
        ])
        ->assertCreated();   
    } 
}
