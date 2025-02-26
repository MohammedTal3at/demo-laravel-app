<?php

namespace App\DTOs\Timesheet;

use App\DTOs\BaseDTO;

class LogTimeDTO extends BaseDTO
{
    public function __construct(
        public readonly string $task_name,
        public readonly string $date,
        public readonly float $hours,
        public readonly int $project_id,
    ) {}
} 