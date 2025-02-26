<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\AssignUsersRequest;
use App\Http\Requests\Project\GetProjectsRequest;

class ProjectController extends Controller
{

    public function __construct(private readonly ProjectService $projectService)
    {
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        $project = $this->projectService->create($request->validated());
        return response()->json($project, 201);
    }


    public function index(GetProjectsRequest $request)
    {
        $filters = $request->getValidatedFilters();
        $projects = $this->projectService->getAllProjects($filters);
        return response()->json($projects);
    }


    public function show(Project $project): JsonResponse
    {
        $project = $this->projectService->getProjectWithDetails($project);
        return response()->json($project);
    }


    public function update(Request $request, Project $project): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'status' => 'sometimes|string|max:255',
            'attributes' => 'array',
        ]);

        $project = $this->projectService->update($project, $validated);

        return response()->json($project);
    }

    // Delete a project and its attributes
    public function destroy(Project $project): JsonResponse
    {
        $this->projectService->delete($project);
        return response()->json(['message' => 'Project deleted'], 204);
    }

    public function timesheets(Project $project): JsonResponse
    {
        $timesheets = $this->projectService->getProjectTimesheets($project);

        return response()->json([
            'status' => 'success',
            'data' => $timesheets
        ]);
    }

    public function assignUsers(AssignUsersRequest $request, Project $project): JsonResponse
    {
        $project = $this->projectService->assignUsers($project, $request->validated()['user_ids']);
        return response()->json([
            'status' => 'success',
            'message' => 'Users assigned successfully',
            'data' => $project
        ]);
    }
}
