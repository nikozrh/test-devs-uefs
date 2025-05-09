<?php

namespace App\Providers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\TagRequest;
use App\Http\Requests\UserRequest;
// use App\Interfaces\Repositories\UserRepositoryInterface; // Removed
// use App\Interfaces\Repositories\PostRepositoryInterface; // Already Removed
// use App\Interfaces\Repositories\TagRepositoryInterface; // Already Removed
// use App\Repositories\UserRepository; // Removed
// use App\Repositories\PostRepository; // Already Removed
// use App\Repositories\TagRepository; // Already Removed
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Repositories
        // $this->app->bind(UserRepositoryInterface::class, UserRepository::class); // Removed
        // $this->app->bind(PostRepositoryInterface::class, PostRepository::class); // Already Removed
        // $this->app->bind(TagRepositoryInterface::class, TagRepository::class); // Already Removed

        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
