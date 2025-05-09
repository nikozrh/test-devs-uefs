<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserReadRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentUserReadRepository implements UserReadRepositoryInterface
{
    public function findById(string $id): ?User
    {
        return User::with('posts')->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return User::with('posts')->where('email', $email)->first();
    }

    public function getAll(array $filters = []): Collection
    {
        $query = User::query();
        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }
        return $query->with('posts')->get();
        return User::with('posts')->get();
    }
}
