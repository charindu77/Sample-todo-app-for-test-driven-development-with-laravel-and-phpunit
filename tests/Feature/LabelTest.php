<?php

namespace Tests\Feature;

use App\Models\Label;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelTest extends TestCase
{
use RefreshDatabase;
private $label;
private $user;
    public function setUp():void
    {
        parent::setUp();
        $this->user=$this->userAuth();
        $this->label=$this->createLabel(['user_id'=>$this->user->id]);
    }
    public function test_user_can_create_a_label()
    {
        $label=Label::factory()->raw();
        $res=$this->postJson(route('label.store'), $label)
        ->assertCreated();
        $this->assertDatabaseHas('labels',['title'=>$label['title'],'color'=>$label['color']]);
    }

    public function test_update_label()
    {
        $response=$this->patchJson(route('label.update',$this->label->id),['title'=>$this->label->title,'color'=>'new color'])
        ->assertOk()
        ->Json('data');

        $this->assertEquals('New Color',$response['color']);

    }

    public function test_delete_label()
    {
        $this->deleteJson(route('label.destroy',$this->label->id))
        ->assertNoContent();

        $this->assertDatabaseMissing('labels',['title'=>$this->label->title]);
    }

    public function test_fetch_all_the_labels_for_user()
    {
        $this->createLabel();

        $response=$this->getJson(route('label.index',$this->user->id))
            ->assertOk()
            ->json('data');

        $this->assertEquals(1,count($response));
        $this->assertEquals($response[0]['title'],$this->label->title);
    }
}
