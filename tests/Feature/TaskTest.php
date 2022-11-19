<?php

namespace Tests\Feature;

use App\Models\Task;
use Facade\Ignition\Tabs\Tab;
use PhpParser\Node\Expr\FuncCall;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    private $task;
    private $list;

    public function setUp():void
    {
        parent::setUp();
        $this->userAuth();
        $this->list=$this->createFactory(['title'=>'my todo']);
        $this->task=$this->createTaskFactory();
    }

    public function test_fetch_all_tasks_for_a_todo_list()
    {               
        $task=$this->createTaskFactory(['todo_list_id'=>$this->list->id]);

        $response=$this->getJson(route('todo-list.task.index',$this->list->id))
            ->assertOk()
            ->json();

        $this->assertEquals(1,count($response));
        $this->assertEquals($task->name,$response[0]['name']);
        $this->assertEquals($this->list->id,$response[0]['todo_list_id']);
    }

    public function test_store_task_for_a_todo_list()
    {
        $task=Task::factory()->make();
        $response=$this->postJson(route('todo-list.task.store',$this->list->id),['name'=>$task->name])
            ->assertCreated();

        $this->assertDatabaseHas('tasks',['name'=>$task->name,'todo_list_id'=>$this->list->id]);
        $this->assertEquals($task->name,$response['name']);
    }

    
    public function test_while_creating_new_task_list_name_is_required()
    {
        $this->withExceptionHandling();

        $this->postJson(route('todo-list.task.store',$this->list->id))
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('name');
    }

    public function test_delete_task()
    {
        $this->deleteJson(route('task.destroy',$this->task->id))
            ->assertNoContent();

        $this->assertDatabaseMissing('tasks',['name'=>$this->task->name]);
    }

    public function test_update_task()
    {  
        $this->patchJson(route('task.update',$this->task->id),['name' => 'updated task name'])
        ->assertOk();
        $this->assertDatabaseHas('tasks',['name' => 'updated task name']);
    }

    public function test_while_updating_task_list_name_is_required()
    {
        $this->withExceptionHandling();

        $this->patchJson(route('task.update',$this->task->id))
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('name');
    }

    public function test_change_task_status()
    {
        $task=$this->createTaskFactory();

        $respond=$this->patchJson(route('task.update',$task->id),['name'=>$task->name,'status'=>Task::OPEN])
            ->assertOk();

        $this->assertEquals(Task::OPEN,$respond['status']);         
    }

    public function test_delete_all_tasks_related_to_a_todo_when_deleting_parent_todo()
    {
        $task=$this->createTaskFactory(['todo_list_id'=>$this->list->id]);
        $response=$this->deleteJson(route('todo-list.destroy',$this->list->id))
                ->assertNoContent();
                

        $this->assertDatabaseMissing('todo_lists',['title'=>$this->list->title]);
        $this->assertDatabaseMissing('tasks',['name'=>$this->task->name,'todo_list_id'=>$this->list->id]);
        $this->assertDatabaseHas('tasks',['name'=>$this->task->name]);
    }  

    public function test_store_task_for_a_todo_list_with_label()
    {
        $task=Task::factory()->make();
        $label=$this->createLabel();

        $response=$this->postJson(route('todo-list.task.store',$this->list->id),
            [
                'name'=>$task->name,
                'label_id'=>$label->id
            ])
            ->assertCreated();

        $this->assertDatabaseHas('tasks',['label_id'=>$label->id,'todo_list_id'=>$this->list->id]);
        $this->assertEquals($task->name,$response['name']);
    }
}  