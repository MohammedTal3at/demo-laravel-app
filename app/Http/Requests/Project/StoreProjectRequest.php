<?php

namespace App\Http\Requests\Project;

use App\DTOs\Project\CreateProjectDTO;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'attributes' => 'array',
            'attributes.*' => 'required',
        ];
    }

    public function toDTO(): CreateProjectDTO
    {
        return new CreateProjectDTO(
            name: $this->validated('name'),
            status: $this->validated('status'),
            attributes: $this->validated('attributes'),
        );
    }
}
