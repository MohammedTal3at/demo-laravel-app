<?php

namespace App\Http\Requests\Project;

use App\DTOs\Project\AssignUsersDTO;
use Illuminate\Foundation\Http\FormRequest;

class AssignUsersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ];
    }

    public function toDTO(): AssignUsersDto
    {
        return new AssignUsersDto(
            user_ids: $this->validate('user_ids'),
        );
    }
}
