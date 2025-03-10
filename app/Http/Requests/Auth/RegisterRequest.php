<?php

namespace App\Http\Requests\Auth;

use App\DTOs\Auth\RegisterDTO;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function toDTO(): RegisterDTO
    {
        return new RegisterDTO(
            first_name: $this->validated('first_name'),
            last_name: $this->validated('last_name'),
            email: $this->validated('email'),
            password: $this->validated('password'),
        );
    }
} 