<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Domain & Infrastructure paths
use App\Domain\User\Repositories\UserReadRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\EloquentUserReadRepository;
use App\Domain\User\Repositories\UserWriteRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\EloquentUserWriteRepository;

use App\Domain\Post\Repositories\PostReadRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\EloquentPostReadRepository;
use App\Domain\Post\Repositories\PostWriteRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\EloquentPostWriteRepository;

use App\Domain\Tag\Repositories\TagReadRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\EloquentTagReadRepository;
use App\Domain\Tag\Repositories\TagWriteRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\EloquentTagWriteRepository;

use App\Domain\Comment\Repositories\CommentReadRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\EloquentCommentReadRepository;
use App\Domain\Comment\Repositories\CommentWriteRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\EloquentCommentWriteRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind User Repositories
        $this->app->bind(
            UserReadRepositoryInterface::class,
            EloquentUserReadRepository::class
        );
        $this->app->bind(
            UserWriteRepositoryInterface::class,
            EloquentUserWriteRepository::class
        );

        // Bind Post Repositories
        $this->app->bind(
            PostReadRepositoryInterface::class,
            EloquentPostReadRepository::class
        );
        $this->app->bind(
            PostWriteRepositoryInterface::class,
            EloquentPostWriteRepository::class
        );

        // Bind Tag Repositories
        $this->app->bind(
            TagReadRepositoryInterface::class,
            EloquentTagReadRepository::class
        );
        $this->app->bind(
            TagWriteRepositoryInterface::class,
            EloquentTagWriteRepository::class
        );

        // Bind Comment Repositories
        $this->app->bind(
            CommentReadRepositoryInterface::class,
            EloquentCommentReadRepository::class
        );
        $this->app->bind(
            CommentWriteRepositoryInterface::class,
            EloquentCommentWriteRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
