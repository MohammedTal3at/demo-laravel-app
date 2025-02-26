<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Repositories\ProjectRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Repositories\TimesheetRepositoryInterface;
use App\Contracts\Repositories\AttributeRepositoryInterface;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\Repositories\TimesheetRepository;
use App\Repositories\AttributeRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TimesheetRepositoryInterface::class, TimesheetRepository::class);
        $this->app->bind(AttributeRepositoryInterface::class, AttributeRepository::class);
    }
} 