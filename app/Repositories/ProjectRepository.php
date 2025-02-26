<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\Attribute;
use App\Contracts\Repositories\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use App\Contracts\Repositories\AttributeRepositoryInterface;

class ProjectRepository implements ProjectRepositoryInterface
{
    private AttributeRepositoryInterface $attributeRepository;

    public function __construct(AttributeRepositoryInterface $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function create(array $data): Project
    {
        $project = Project::create([
            'name' => $data['name'],
            'status' => $data['status'],
        ]);

        if (isset($data['attributes'])) {
            foreach ($data['attributes'] as $attributeId => $value) {
                $project->attributeValues()->create([
                    'attribute_id' => $attributeId,
                    'value' => $value,
                ]);
            }
        }

        return $project->load('attributeValues.attribute');
    }

    public function getAllWithFilters(array $filters = []): Collection
    {
        $regularFields = Schema::getColumnListing('projects');
        $eavAttributes = $this->attributeRepository->getAllAttributeNames();

        return Project::with('attributeValues.attribute')
            ->where(function (Builder $query) use ($filters, $regularFields, $eavAttributes) {
                foreach ($filters as $field => $condition) {
                    $this->applyFilter($query, $field, $condition, $regularFields, $eavAttributes);
                }
            })
            ->get();
    }

    private function applyFilter(Builder $query, string $field, array $condition, array $regularFields, array $eavAttributes): void
    {
        $operator = $condition['operator'];
        $value = $condition['value'];

        if ($operator === 'like') {
            $value = '%' . $value . '%';
        }

        if (in_array($field, $regularFields)) {
            $query->where($field, $operator, $value);
        } elseif (in_array($field, $eavAttributes)) {
            $query->whereHas('attributeValues', function (Builder $q) use ($field, $operator, $value) {
                $q->whereHas('attribute', function (Builder $q) use ($field) {
                    $q->where('name', $field);
                })->where('value', $operator, $value);
            });
        }
    }

    public function getWithDetails(Project $project): Project
    {
        return $project->load('attributeValues.attribute');
    }

    public function update(Project $project, array $data): Project
    {
        $project->update([
            'name' => $data['name'] ?? $project->name,
            'status' => $data['status'] ?? $project->status,
        ]);

        if (isset($data['attributes'])) {
            foreach ($data['attributes'] as $attributeId => $value) {
                $project->attributeValues()->updateOrCreate(
                    ['attribute_id' => $attributeId],
                    ['value' => $value]
                );
            }
        }

        return $project->load('attributeValues.attribute');
    }

    public function delete(Project $project): void
    {
        $project->delete();
    }

    public function getTimesheets(Project $project): LengthAwarePaginator
    {
        return $project->timeSheets()
            ->with('user')
            ->latest()
            ->paginate();
    }

    public function assignUsers(Project $project, array $userIds): Project
    {
        $project->users()->sync($userIds);
        return $project->load('users');
    }
} 