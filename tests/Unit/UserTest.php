<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;


class UserTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_has_many_todo_lists()
    {
        $user=$this->createUser();
        $this->createFactory(['user_id'=> $user->id]);

        $this->assertInstanceOf(TodoList::class,$user->todoLists->first());
    }
}
