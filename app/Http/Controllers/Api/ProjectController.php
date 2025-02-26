<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\AssignUsersRequest;
use App\Http\Requests\Project\GetProjectsRequest;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    // Store a new project and its dynamic attributes
    public function store(StoreProjectRequest $request)
    {
        $project = $this->projectService->create($request->validated());
        return response()->json($project, 201);
    }

    // Fetch projects with dynamic attributes
    public function index(GetProjectsRequest $request)
    {
        $filters = $request->getValidatedFilters();
        $projects = $this->projectService->getAllProjects($filters);
        return response()->json($projects);
    }

    // Show a specific project with attributes
    public function show(Project $project)
    {
        $project = $this->projectService->getProjectWithDetails($project);
        return response()->json($project);
    }

    // Update a project's attributes
    public function update(Request $request, Project $project)
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
    public function destroy(Project $project)
    {
        $this->projectService->delete($project);
        return response()->json(['message' => 'Project deleted'], 204);
    }

    public function timesheets(Project $project)
    {
        $timesheets = $this->projectService->getProjectTimesheets($project);

        return response()->json([
            'status' => 'success',
            'data' => $timesheets
        ]);
    }

    public function assignUsers(AssignUsersRequest $request, Project $project)
    {
        $project = $this->projectService->assignUsers($project, $request->validated()['user_ids']);
        return response()->json([
            'status' => 'success',
            'message' => 'Users assigned successfully',
            'data' => $project
        ]);
    }
}
