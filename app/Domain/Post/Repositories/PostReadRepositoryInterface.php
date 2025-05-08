<?php

namespace App\Domain\Post\Repositories;

use App\Domain\Post\Entities\Post;
use Illuminate\Database\Eloquent\Collection;

interface PostReadRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?Post;
}
