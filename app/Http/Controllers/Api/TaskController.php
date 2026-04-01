<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = Task::create(array_merge($request->validated(), ['status' => 'pending']));
        return response()->json($task, 201);
    }

    public function index(Request $request): JsonResponse
    {
        $query = Task::query();
        if ($request->has('status')) $query->where('status', $request->status);

        $tasks = $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
                       ->orderBy('due_date', 'asc')->get();

        if ($tasks->isEmpty()) return response()->json(['message' => 'No tasks found.'], 200);
        return response()->json($tasks);
    }

    public function updateStatus(UpdateTaskStatusRequest $request, Task $task): JsonResponse
    {
        $newStatus = $request->status;
        $currentStatus = $task->status;
        $transitions = ['pending' => 'in_progress', 'in_progress' => 'done'];

        if (!array_key_exists($currentStatus, $transitions) || $transitions[$currentStatus] !== $newStatus) {
            return response()->json(['error' => "Invalid status transition."], 422);
        }

        $task->update(['status' => $newStatus]);
        return response()->json($task);
    }

    public function destroy(Task $task): JsonResponse
    {
        if ($task->status !== 'done') return response()->json(['error' => 'Only done tasks can be deleted.'], 403);
        $task->delete();
        return response()->json(['message' => 'Task deleted.'], 200);
    }

    public function report(Request $request): JsonResponse
    {
        $request->validate(['date' => 'required|date']);
        $tasks = Task::whereDate('due_date', $request->date)->get();

        $summary = [
            'high' => ['pending' => 0, 'in_progress' => 0, 'done' => 0],
            'medium' => ['pending' => 0, 'in_progress' => 0, 'done' => 0],
            'low' => ['pending' => 0, 'in_progress' => 0, 'done' => 0],
        ];

        foreach ($tasks as $task) $summary[$task->priority][$task->status]++;

        return response()->json(['date' => $request->date, 'summary' => $summary]);
    }
}