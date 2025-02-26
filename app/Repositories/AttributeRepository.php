<?php

namespace App\Repositories;

use App\Models\Attribute;
use App\Contracts\Repositories\AttributeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AttributeRepository implements AttributeRepositoryInterface
{
    public function create(array $data): Attribute
    {
        return Attribute::create([
            'name' => $data['name'],
            'type' => $data['type'],
        ]);
    }

    public function getAll(): Collection
    {
        return Attribute::all();
    }

    public function findById(int $id): ?Attribute
    {
        return Attribute::find($id);
    }

    public function update(Attribute $attribute, array $data): Attribute
    {
        $attribute->update([
            'name' => $data['name'] ?? $attribute->name,
            'type' => $data['type'] ?? $attribute->type,
        ]);

        return $attribute->fresh();
    }

    public function delete(Attribute $attribute): void
    {
        $attribute->delete();
    }

    public function getAllAttributeNames(): array
    {
        return Attribute::pluck('name')->toArray();
    }
} 