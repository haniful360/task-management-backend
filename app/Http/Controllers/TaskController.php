<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->get(); // Fetch tasks for the authenticated user
        return TaskResource::collection($tasks); // Return tasks in a standardized format
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $data = $request->validated(); // Validate and get the data
        $data['user_id'] = Auth::id(); // Assign authenticated user's ID

        $task = Task::create($data); // Create the task

        return new TaskResource($task); // Return created task in a standardized format
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

        return new TaskResource($task); // Return the task if found
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found.',
            ], 404);
        }

        $task->update($request->validated()); // Update the task with validated data

        return new TaskResource($task); // Return updated task
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found.',
            ], 404);
        }

        $task->delete(); // Delete the task

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully!',
        ], 200);
    }
}
