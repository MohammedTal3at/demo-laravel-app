<?php

namespace App\Services;

use App\Models\Project;
use App\Contracts\Repositories\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectService
{
    private ProjectRepositoryInterface $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function create(array $data): Project
    {
        return $this->projectRepository->create($data);
    }

    public function getAllProjects(array $filters = []): Collection
    {
        return $this->projectRepository->getAllWithFilters($filters);
    }

    public function getProjectWithDetails(Project $project): Project
    {
        return $this->projectRepository->getWithDetails($project);
    }

    public function update(Project $project, array $data): Project
    {
        return $this->projectRepository->update($project, $data);
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
