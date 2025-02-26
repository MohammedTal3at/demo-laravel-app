<?php

namespace App\DTOs\Attribute;

use App\DTOs\BaseDTO;

class CreateAttributeDTO extends BaseDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $type,
    ) {}
} 