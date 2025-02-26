<?php

namespace App\Services;

use App\Contracts\Repositories\TimesheetRepositoryInterface;
use App\Models\TimeSheet;
use Illuminate\Pagination\LengthAwarePaginator;

class TimesheetService
{
    private TimesheetRepositoryInterface $timesheetRepository;

    public function __construct(TimesheetRepositoryInterface $timesheetRepository)
    {
        $this->timesheetRepository = $timesheetRepository;
    }

    public function logTime(array $data, int $userId): TimeSheet
    {
        return $this->timesheetRepository->create($data, $userId);
    }

    public function getUserTimesheets(int $userId, array $filters = []): LengthAwarePaginator
    {
        return $this->timesheetRepository->getUserTimesheets($userId, $filters);
    }
} 