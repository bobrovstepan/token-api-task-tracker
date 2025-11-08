<?php

namespace App\Models;

use App\Services\Task\TaskFilters;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Task extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',
        'finished_at',
        'user_id',
    ];

    protected $appends = ['attachment_url'];

    protected $hidden = ['media'];

    public function getAttachmentUrlAttribute(): ?string
    {
        $media = $this->getFirstMedia('task_attachments');

        return $media ? $media->getUrl() : null;
    }

    public function scopeOfUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeFilter($query, array $filters)
    {
        return (new TaskFilters($query, $filters))->apply();
    }
}
