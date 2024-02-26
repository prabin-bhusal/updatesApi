<?php

namespace App\Providers;

use App\Repositories\CommentRepository;
use App\Repositories\CommentRepositoryInterface;
use App\Repositories\NewsRepository;
use App\Repositories\NewsRepositoryInterface;
use App\Repositories\NoticeRepository;
use App\Repositories\NoticeRepositoryInterface;
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
        $this->app->bind(NoticeRepositoryInterface::class, NoticeRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
