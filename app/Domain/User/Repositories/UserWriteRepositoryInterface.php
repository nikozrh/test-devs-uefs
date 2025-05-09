<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\Entities\User;

interface UserWriteRepositoryInterface
{
    public function save(User $user): User;
    public function update(User $user, array $data): User;
    public function delete(string $id): bool;
}
