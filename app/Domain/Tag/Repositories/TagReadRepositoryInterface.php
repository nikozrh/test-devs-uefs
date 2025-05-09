<?php

namespace App\Domain\Tag\Repositories;

use App\Domain\Tag\Entities\Tag;
use Illuminate\Database\Eloquent\Collection;

interface TagReadRepositoryInterface
{
    public function getAll(): Collection;

    public function findById(int $id): ?Tag;

    public function findByName(string $name): ?Tag;
}
