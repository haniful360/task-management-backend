<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();
        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        // $validated = $request->validate([

        // ]);

        $task = Task::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Task created successfully!',
            'data' => new TaskResource($task),
        ], 201);

        return response()->json([
            'success' => false,
            'message' => 'An error occurred',
        ], 500);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new TaskResource($task),
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|in:pending,approved',
            'due_date' => 'nullable|date',
            'user_id' => 'sometimes|required|exists:users,id',
        ]);

        $task->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully!',
            'data' => new TaskResource($task),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully!',
        ]);
    }
}
