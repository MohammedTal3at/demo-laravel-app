<?php

namespace App\Contracts\Repositories;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Collection;

interface AttributeRepositoryInterface
{
    public function create(array $data): Attribute;
    public function getAll(): Collection;
    public function findById(int $id): ?Attribute;
    public function update(Attribute $attribute, array $data): Attribute;
    public function delete(Attribute $attribute): void;
    public function getAllAttributeNames(): array;
} 