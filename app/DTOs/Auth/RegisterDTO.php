<?php

namespace App\DTOs\Auth;

use App\DTOs\BaseDTO;

class RegisterDTO extends BaseDTO
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly string $password,
    ) {}
} 