<?php

namespace App\Contracts\Repositories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProjectRepositoryInterface
{
    public function create(array $data): Project;
    public function getAllWithFilters(array $filters = []): Collection;
    public function getWithDetails(Project $project): Project;
    public function update(Project $project, array $data): Project;
    public function delete(Project $project): void;
    public function getTimesheets(Project $project): LengthAwarePaginator;
    public function assignUsers(Project $project, array $userIds): Project;
} 