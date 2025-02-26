<?php

namespace App\Services;

use App\DTOs\Project\CreateProjectDTO;
use App\Models\Project;
use App\Contracts\Repositories\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectService
{

    public function __construct(private readonly ProjectRepositoryInterface $projectRepository)
    {
    }

    public function create(CreateProjectDTO $data): Project
    {
        return $this->projectRepository->create($data->toArray());
    }

    public function getAllProjects(array $filters = []): Collection
    {
        return $this->projectRepository->getAllWithFilters($filters);
    }

    public function getProjectWithDetails(Project $project): Project
    {
        return $this->projectRepository->getWithDetails($project);
    }

    public function update(Project $project, CreateProjectDTO $createProjectDTO): Project
    {
        return $this->projectRepository->update($project, $createProjectDTO->toArray());
    }

    public function delete(Project $project): void
    {
        $this->projectRepository->delete($project);
    }

    public function getProjectTimesheets(Project $project): LengthAwarePaginator
    {
        return $this->projectRepository->getTimesheets($project);
    }

    public function assignUsers(Project $project, array $userIds): Project
    {
        return $this->projectRepository->assignUsers($project, $userIds);
    }
}
