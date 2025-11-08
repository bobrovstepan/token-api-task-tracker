<?php
namespace App\Services\Task;

use Composer\XdebugHandler\Status;

class TaskFilters
{
    public function __construct(
        public $query,
        public array $filters
    ){}

    public function apply()
    {
        foreach ($this->filters as $name => $value) {
            if (method_exists($this, $method = 'filter' . str($name)->studly())) {
                $this->{$method}($value);
            }
        }

        return $this->query;
    }

    private function filterStatus(string $value): void
    {
        if ($value) {
            $this->query->where('status', $value);
        }
    }

    private function filterFinishedAt(string $value): void
    {
        if ($value) {
            $this->query->whereDate('finished_at', $value);
        }
    }
}
