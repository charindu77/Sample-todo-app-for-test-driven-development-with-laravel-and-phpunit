<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Tests\TestCase;
use App\Models\TodoList;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;

    private $list;

    public function setUp():void
    {
        parent::setUp();
        $user=$this->userAuth();
        $this->list = $this->createFactory(['user_id'=> $user->id]);
    }

    public function test_get_all_todo_lists()
    {
        $this->createFactory();
        $response=$this->getJson(route('todo-list.index'))->json('data');
        $this->assertEquals(1,count($response));
    }

    public function test_get_single_todo()
    {
        $response=$this->getJson(route('todo-list.show',$this->list->id))
            ->assertOk()
            ->json('data');

        $this->assertEquals($response['title'],$this->list->title);
    }

    public function test_create_new_todo_list()
    {
        // declare
        $list=TodoList::factory()->make();
        // action
        $response=$this->postJson(route('todo-list.store',['title' =>$list->title]))
            ->assertCreated()
            ->json();
        // assertion
        $this->assertEquals($list->title,$response['data']['title']);
        $this->assertDatabaseHas('todo_lists',['title'=>$list->title]);
    }

    public function test_while_creating_new_todo_list_title_is_required()
    {
        $this->withExceptionHandling();

        $this->postJson(route('todo-list.store'))
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('title');
    }

    public function test_delete_todo_list()
    {
        $this->deleteJson(route('todo-list.destroy',$this->list->id))
            ->assertNoContent();

        $this->assertDatabaseMissing('todo_lists',['title'=>$this->list->title]);
    }

    public function test_update_todo_list()
    {
        $this->patchJson(route('todo-list.update',$this->list->id),['title' =>'Updated list'])
            ->assertOk();

        $this->assertDatabaseHas('todo_lists',['title'=>'Updated list']);
    }

    public function test_while_updating_todo_list_title_is_required()
    {
        $this->withExceptionHandling();

        $this->patchJson(route('todo-list.update',$this->list->id))
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('title');
    }

}