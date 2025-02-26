<?php

namespace App\Http\Requests\Auth;

use App\DTOs\Auth\UpdateProfileDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . Auth::id(),
            'password' => 'sometimes|string|min:6|confirmed',
        ];
    }

    public function toDTO(): UpdateProfileDTO
    {
        return new UpdateProfileDTO(
            first_name: $this->validated('first_name'),
            last_name: $this->validated('last_name'),
            email: $this->validated('email'),
            password: $this->validated('password'),
        );
    }
} 