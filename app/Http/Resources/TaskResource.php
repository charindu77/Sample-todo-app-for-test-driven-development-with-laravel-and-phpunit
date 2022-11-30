<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name'=> $this->name,
            'description'=> $this->description,
            'todo_list_title'=> $this->todoList->title,
            'status'=> $this->status,
            'created_at'=> $this->created_at->diffForHumans(),
        ];
    }
}
