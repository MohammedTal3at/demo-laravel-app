<?php

namespace App\Http\Requests\Attribute;

use App\DTOs\Attribute\UpdateAttributeDTO;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAttributeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|string|in:text,number,date,boolean',
        ];
    }

    public function toDTO(): UpdateAttributeDTO
    {
        return new UpdateAttributeDTO(
            name: $this->validated('name'),
            type: $this->validated('type'),
        );
    }
} 