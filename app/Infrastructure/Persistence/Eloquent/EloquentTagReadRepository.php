<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Tag\Entities\Tag;
use App\Domain\Tag\Repositories\TagReadRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentTagReadRepository implements TagReadRepositoryInterface
{
    public function getAll(): Collection
    {
        return Tag::with('posts')->get();
    }

    public function findById(int $id): ?Tag
    {
        return Tag::with('posts')->find($id);
    }

    public function findByName(string $name): ?Tag
    {
        return Tag::with('posts')->where('name', $name)->first();
    }
}
