<?php

namespace App\DTOs\Project;

use App\DTOs\BaseDTO;

class CreateProjectDTO extends BaseDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $status,
        public readonly ?array $attributes = [],
    ) {}
} 