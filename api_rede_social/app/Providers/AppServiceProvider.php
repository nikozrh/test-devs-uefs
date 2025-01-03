<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\UsuarioRepositoryInterface;
use App\Repositories\Eloquent\UsuarioRepository;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Eloquent\PostRepository;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Repositories\Eloquent\TagRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UsuarioRepositoryInterface::class, UsuarioRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
