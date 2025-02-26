<?php

namespace App\DTOs\Attribute;

use App\DTOs\BaseDTO;

class UpdateAttributeDTO extends BaseDTO
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $type = null,
    ) {}
} 