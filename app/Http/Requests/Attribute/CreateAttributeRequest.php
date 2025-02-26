<?php

namespace App\Http\Requests\Attribute;

use App\DTOs\Attribute\CreateAttributeDTO;
use Illuminate\Foundation\Http\FormRequest;

class CreateAttributeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:text,number,date,boolean',
        ];
    }

    public function toDTO(): CreateAttributeDTO
    {
        return new CreateAttributeDTO(
            name: $this->validated('name'),
            type: $this->validated('type'),
        );
    }
} 