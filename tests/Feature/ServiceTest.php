<?php

namespace Tests\Feature;

use Google\Client;
use Tests\TestCase;
use App\Models\WebService;
use Mockery\MockInterface;
use Illuminate\Foundation\Testing\WithFaker;
use Google\Service\CloudComposer\WebServerConfig;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;
    private $user;

    public function setUp():void
    {
        parent::setUp();
        $this->user=$this->userAuth();
    }

    public function test_a_authenticated_user_can_connect_to_drive_service_and_store_access_token()
    {

        $this->mock(Client::class, function (MockInterface $mock) {
            $mock->shouldReceive('addScope')->once();
            $mock->shouldReceive('createAuthUrl')
                ->andReturn('http://localhost');
        });

        $response = $this->getJson(route('service.connect','google-drive'))
        ->assertOk()
        ->json();

        $this->assertNotEmpty($response['url']);
        $this->assertEquals('http://localhost',$response['url']);
    }

    public function test_web_service_callback_store_token()
    {
        $this->mock(Client::class, function (MockInterface $mock) {
            $mock->shouldReceive('fetchAccessTokenWithAuthCode')
                ->andReturn('fake-token');
        });

        $this->postJson(route('service.callback'),['code'=>'dummy-code'])
        ->assertCreated();

        $service=WebService::first();

        $this->assertDatabaseHas('web_services',
        [
            'user_id'=> $this->user->id,
            'token'=>'{"access-token":"fake-token"}'
        ]);
        // $this->assertNotNull($this->user->services->first()->token);
    }
}
