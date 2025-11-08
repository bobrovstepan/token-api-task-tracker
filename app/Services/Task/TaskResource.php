<?php
namespace App\Services\Task;

class TaskResource
{
    public static function collect(string $projectId, int $userId, array $data): array
    {
        return [
            'project_id' => $projectId,
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
            'finished_at' => $data['finished_at'] ?? null,
            'user_id' => $userId,
        ];
    }
}
