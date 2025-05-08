<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserWriteRepositoryInterface;
use Illuminate\Support\Facades\DB; 

class EloquentUserWriteRepository implements UserWriteRepositoryInterface
{
    public function save(User $user): User
    {
        return DB::transaction(function () use ($user) {
            $user->save();
            return $user->fresh();
        });
    }

    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            $user->fill($data);
            $user->save();
            return $user->fresh();
        });
    }

    public function delete(string $id): bool
    {
        return DB::transaction(function () use ($id) {
            $user = User::find($id);
            if ($user) {
                return $user->delete();
            }
            return false;
        });
    }
}