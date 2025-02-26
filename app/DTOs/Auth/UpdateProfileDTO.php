<?php

namespace App\DTOs\Auth;

use App\DTOs\BaseDTO;

class UpdateProfileDTO extends BaseDTO
{
    public function __construct(
        public readonly ?string $first_name = null,
        public readonly ?string $last_name = null,
        public readonly ?string $email = null,
        public readonly ?string $password = null,
    ) {}
} 