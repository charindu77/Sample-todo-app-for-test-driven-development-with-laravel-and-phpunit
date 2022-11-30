<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Http\Requests\TaskRequest;
use App\Models\TodoList;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\TaskResource
     */
    public function index(TodoList $todo_list)
    {
        $task=$todo_list->tasks;
        return TaskResource::collection($task);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @return \App\Http\Resources\TaskResource
     */
    public function store(TaskRequest $request, TodoList $todo_list)
    {        
        $task= $todo_list->tasks()->create($request->validated());
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \App\Http\Resources\TaskResource
     */
    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response([''],Response::HTTP_NO_CONTENT);
    }
}
