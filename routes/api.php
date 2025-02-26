<?php

use App\Http\Controllers\Api\AttributeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TimesheetController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:api')
    ->name('auth.logout');

// Protected routes
Route::middleware('auth:api')->group(function () {
    // User profile
    Route::get('/profile', [AuthController::class, 'profile'])->name('auth.profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('auth.profile.update');

    // Attributes
    Route::apiResource('attributes', AttributeController::class);

    // Projects
    Route::apiResource('projects', ProjectController::class);
    Route::get('/projects/{project}/timesheets', [ProjectController::class, 'timesheets'])
        ->name('projects.timesheets');
    Route::post('/projects/{project}/users', [ProjectController::class, 'assignUsers'])
        ->name('projects.assign-users');

    // Timesheet routes
    Route::post('/timesheets', [TimesheetController::class, 'store'])->name('timesheets.store');
    Route::get('/my-timesheets', [TimesheetController::class, 'getUserTimesheets'])->name('timesheets.my');
});
