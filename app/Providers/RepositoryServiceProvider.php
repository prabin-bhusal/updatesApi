<?php

namespace App\Providers;

use App\Repositories\NewsRepository;
use App\Repositories\NewsRepositoryInterface;
use App\Repositories\ResourceRepository;
use App\Repositories\ResourceRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(NewsRepositoryInterface::class, NewsRepository::class);
        $this->app->bind(ResourceRepositoryInterface::class, ResourceRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
