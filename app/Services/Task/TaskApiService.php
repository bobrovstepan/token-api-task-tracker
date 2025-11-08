<?php
namespace App\Services\Task;

use App\Models\Project;
use App\Models\Task;
use App\Notifications\TaskCreatedNotification;
use Illuminate\Http\UploadedFile;

class TaskApiService
{
    public function getByProject(Project $project, array $query): array
    {
        return $project
            ->tasks()
            ->ofUser(auth()->user()->id)
            ->filter($query)
            ->get()
            ->toArray();
    }

    public function get(Task $task): array
    {
        return $task->toArray();
    }

    public function store(Project $project, array $data, ?UploadedFile $attachment = null): array
    {
        $task = Task::create(TaskResource::collect(
            $project->id,
            auth()->user()->id,
            $data
        ));

        if ($attachment) {
            $task->addMedia($attachment)->toMediaCollection('task_attachments');
        }

        //TODO: remake with event
        auth()->user()?->notify(new TaskCreatedNotification());

        return $task->toArray();
    }

    /**
     * Whole resource update
     */
    public function update(Task $task, array $data, ?UploadedFile $attachment = null): array
    {

        $task->update(TaskResource::collect(
            $task->project_id,
            $task->user_id,
            $data
        ));

        $task->clearMediaCollection('task_attachments');
        if ($attachment) $task->addMedia($attachment)->toMediaCollection('task_attachments');

        return $task->toArray();
    }

    public function remove(Task $task): void
    {
        $task->delete();
    }
}
