<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_task_belongs_to_todo()
    {   
        $list=$this->createFactory();
        $task=$this->createTaskFactory(['todo_list_id'=> $list->id]);

        $this->assertInstanceOf(TodoList::class,$task->todoList);
    }
}
