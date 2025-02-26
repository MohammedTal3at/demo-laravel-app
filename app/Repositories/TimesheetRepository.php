<?php

namespace App\Repositories;

use App\Models\TimeSheet;
use App\Contracts\Repositories\TimesheetRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class TimesheetRepository implements TimesheetRepositoryInterface
{
    public function create(array $data, int $userId): TimeSheet
    {
        $timesheet = TimeSheet::create([
            'task_name' => $data['task_name'],
            'date' => $data['date'],
            'hours' => $data['hours'],
            'project_id' => $data['project_id'],
            'user_id' => $userId,
        ]);

        return $timesheet->load('project');
    }

    public function getUserTimesheets(int $userId, array $filters = []): LengthAwarePaginator
    {
        return TimeSheet::with('project')
            ->where('user_id', $userId)
            ->when(isset($filters['date']), function ($query) use ($filters) {
                return $query->whereDate('date', $filters['date']);
            })
            ->when(isset($filters['project_id']), function ($query) use ($filters) {
                return $query->where('project_id', $filters['project_id']);
            })
            ->latest()
            ->paginate();
    }
} 