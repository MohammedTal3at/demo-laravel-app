<?php

namespace App\Services;

use App\Models\Attribute;
use App\Contracts\Repositories\AttributeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AttributeService
{
    private AttributeRepositoryInterface $attributeRepository;

    public function __construct(AttributeRepositoryInterface $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function create(array $data): Attribute
    {
        return $this->attributeRepository->create($data);
    }

    public function getAllAttributes(): Collection
    {
        return $this->attributeRepository->getAll();
    }

    public function update(Attribute $attribute, array $data): Attribute
    {
        return $this->attributeRepository->update($attribute, $data);
    }

    public function delete(Attribute $attribute): void
    {
        $this->attributeRepository->delete($attribute);
    }
}
