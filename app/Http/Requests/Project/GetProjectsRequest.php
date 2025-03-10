<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Attribute;
use Illuminate\Support\Facades\Schema;

class GetProjectsRequest extends FormRequest
{
    private array $allowedOperators = ['=', '>', '<', '>=', '<=', 'like'];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'filters' => 'array',
            'filters.*.*' => 'string',
        ];
    }

    public function getValidatedFilters(): array
    {
        $regularFields = Schema::getColumnListing('projects');
        $eavAttributes = Attribute::pluck('name')->toArray();

        $rawFilters = $this->get('filters', []);
        $parsedFilters = [];

        foreach ($rawFilters as $field => $value) {
            // Handle operator syntax (e.g., "filters[name][like]" => "value")
            if (is_array($value)) {
                $operator = array_key_first($value);
                $value = $value[$operator];
                // Validate operator
                if (!in_array($operator, $this->allowedOperators)) {
                    continue;
                }
            } else {
                $operator = '=';
            }

            // Only include valid fields
            if (!in_array($field, $regularFields) && !in_array($field, $eavAttributes)) {
                continue;
            }

            $parsedFilters[$field] = [
                'operator' => $operator,
                'value' => $value
            ];
        }

        return $parsedFilters;
    }

    public function messages(): array
    {
        return [
            'filters.array' => 'Filters must be provided as an array',
            'filters.*.string' => 'Filter values must be strings',
        ];
    }
}
