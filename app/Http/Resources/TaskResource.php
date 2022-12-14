<?php

namespace App\Http\Resources;

use App\Http\Resources\TodoResource;
use App\Http\Resources\LabelResource;
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
            'todo_list'=> new TodoResource($this->todoList),
            'status'=> $this->status,
            'label'=> new LabelResource($this->label),
            'created_at'=> $this->created_at->diffForHumans(),
        ];
    }
}
