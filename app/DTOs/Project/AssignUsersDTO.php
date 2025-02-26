<?php

namespace App\DTOs\Project;

use App\DTOs\BaseDTO;

class AssignUsersDTO extends BaseDTO
{
    public function __construct(
        public readonly array $user_ids,
    ) {}
} 