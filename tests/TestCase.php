<?php

namespace Tests;

use App\Models\Task;
use App\Models\User;
use App\Models\Label;
use App\Models\TodoList;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp():void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function createFactory($args=[]){
        return TodoList::factory()->create($args);
    }
    public function createTaskFactory($args=[]){
        return Task::factory()->create($args);
    }
    public function createUser($args=[]){
        return User::factory()->create($args);
    }

    public function userAuth($args=[]){
        $user=$this->createUser();
        Sanctum::actingAs($user);
        return $user;
    }

    public function createLabel($args=[]){
        return Label::factory()->create($args);
    }

}
