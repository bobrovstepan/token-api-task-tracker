<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Services\Task\TaskApiService;
use Illuminate\Http\Request;

class TaskApiController extends Controller
{
    public function __construct(
        private TaskApiService $taskApiService
    ){}

    public function index(Request $request, Project $project): \Illuminate\Http\JsonResponse
    {
        $tasks = $this->taskApiService->getByProject($project, $request->query());

        return response()->json([
            'success' => true,
            'tasks' => $tasks
        ], 200);
    }

    public function store(StoreTaskRequest $request, Project $project): \Illuminate\Http\JsonResponse
    {
        $task = $this->taskApiService->store($project, $request->input(), $request->file('attachment'));

        return response()->json([
            'success' => true,
            'task' => $task
        ], 201);
    }

    public function show(Task $task): \Illuminate\Http\JsonResponse
    {
        $task = $this->taskApiService->get($task);

        return response()->json([
            'success' => true,
            'task' => $task
        ], 200);
    }

    public function update(UpdateTaskRequest $request, Task $task): \Illuminate\Http\JsonResponse
    {
        $updatedTask = $this->taskApiService->update($task, $request->input(), $request->file('attachment'));

        return response()->json([
            'success' => true,
            'task' => $updatedTask
        ], 200);
    }

    public function destroy(Task $task): \Illuminate\Http\JsonResponse
    {
        $this->taskApiService->remove($task);

        return response()->json([
            'success' => true,
            'message' => 'Task removed'
        ], 200);
    }
}
