<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_todo_has_many_tasks()
    {   
        $list=$this->createFactory();
        $this->createTaskFactory(['todo_list_id'=> $list->id]);

        $this->assertInstanceOf(Task::class,$list->tasks->first());
    }
}
