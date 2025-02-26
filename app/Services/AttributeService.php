<?php

namespace App\Services;

use App\Models\Attribute;
use App\Contracts\Repositories\AttributeRepositoryInterface;
use App\DTOs\Attribute\CreateAttributeDTO;
use App\DTOs\Attribute\UpdateAttributeDTO;
use Illuminate\Database\Eloquent\Collection;

class AttributeService
{
    private AttributeRepositoryInterface $attributeRepository;

    public function __construct(AttributeRepositoryInterface $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function create(CreateAttributeDTO $dto): Attribute
    {
        return $this->attributeRepository->create($dto->toArray());
    }

    public function getAllAttributes(): Collection
    {
        return $this->attributeRepository->getAll();
    }

    public function update(Attribute $attribute, UpdateAttributeDTO $dto): Attribute
    {
        $data = array_filter($dto->toArray(), fn($value) => !is_null($value));
        return $this->attributeRepository->update($attribute, $data);
    }

    public function delete(Attribute $attribute): void
    {
        $this->attributeRepository->delete($attribute);
    }
}
