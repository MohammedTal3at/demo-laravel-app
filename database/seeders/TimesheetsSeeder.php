<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\TimeSheet;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TimesheetsSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::with('users')->get();

        foreach ($projects as $project) {
            foreach ($project->users as $user) {
                // Create timesheets for the last 5 days
                for ($i = 0; $i < 5; $i++) {
                    TimeSheet::create([
                        'user_id' => $user->id,
                        'project_id' => $project->id,
                        'task_name' => "Task " . ($i + 1),
                        'date' => Carbon::now()->subDays($i)->format('Y-m-d'),
                        'hours' => rand(2, 8),
                    ]);
                }
            }
        }
    }
} 