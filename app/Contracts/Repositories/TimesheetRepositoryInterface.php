<?php

namespace App\Contracts\Repositories;

use App\Models\TimeSheet;
use Illuminate\Pagination\LengthAwarePaginator;

interface TimesheetRepositoryInterface
{
    public function create(array $data, int $userId): TimeSheet;
    public function getUserTimesheets(int $userId, array $filters = []): LengthAwarePaginator;
} 