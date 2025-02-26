<?php

namespace App\Http\Requests\Timesheet;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LogTimeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'task_name' => 'required|string|max:255',
            'date' => 'required|date',
            'hours' => 'required|numeric|min:0|max:24',
            'project_id' => [
                'required',
                'exists:projects,id',
                Rule::exists('project_user', 'project_id')
                    ->where('user_id', auth()->id()),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.exists' => 'The selected project is invalid or you are not assigned to it.'
        ];
    }
} 