<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskFormRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $tasks = $user->tasks()->latest()->paginate(10);
        return TaskResource::collection($tasks);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskFormRequest $request)
    {
        $user = $request->user();
        $user->tasks()->create($request->validated());
        return response()->json([
            "status" => true,
            "message" => "New Task Created"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return TaskResource::make($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskFormRequest $request, Task $task)
    {
        $task->update($request->validated());
        return response()->json([
            "status" => true,
            "message" => "Task Updated"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json([
            "status" => true,
            "message" => "Task Deleted"
        ], 204);

    }
}
