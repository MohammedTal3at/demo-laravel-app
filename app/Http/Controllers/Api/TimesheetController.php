<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\TimesheetService;
use App\Http\Requests\Timesheet\LogTimeRequest;

class TimesheetController extends Controller
{

    public function __construct(private readonly TimesheetService $timesheetService)
    {
    }

    public function store(LogTimeRequest $request): JsonResponse
    {
        $timesheet = $this->timesheetService->logTime(
            $request->validated(),
            auth()->id()
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Time logged successfully',
            'data' => $timesheet
        ], 201);
    }

    public function getUserTimesheets(Request $request): JsonResponse
    {
        $timesheets = $this->timesheetService->getUserTimesheets(
            Auth::id(),
            $request->only(['date', 'project_id'])
        );

        return response()->json([
            'status' => 'success',
            'data' => $timesheets
        ]);
    }
}
