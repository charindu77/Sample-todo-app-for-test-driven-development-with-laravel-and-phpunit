<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;
use App\Http\Resources\TodoResource;
use App\Http\Requests\TodoListRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Service\Attribute\Required;

class ToDoListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $todo_list=auth()->user()->todoLists;
        return TodoResource::collection($todo_list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\TodoResource
     */
    public function store(TodoListRequest $request)
    {
        return new TodoResource(auth()->user()->todoLists()->create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Resources\TodoResource
     */
    public function show(TodoList $todo_list)
    {
        return new TodoResource($todo_list);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \App\Http\Resources\TodoResource
     */
    public function update(TodoListRequest $request, TodoList $todo_list)
    {
        $todo_list->update($request->all());
        return new TodoResource($todo_list);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TodoList $todo_list)
    {
        $todo_list->delete();
        return response('',Response::HTTP_NO_CONTENT);
    }
}
