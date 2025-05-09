<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Tag\Entities\Tag;
use App\Domain\Tag\Repositories\TagWriteRepositoryInterface;

class EloquentTagWriteRepository implements TagWriteRepositoryInterface
{
    public function create(array $data): Tag
    {
        return Tag::create($data);
    }

    public function update(int $id, array $data): ?Tag
    {
        $tag = Tag::find($id);
        if ($tag) {
            $tag->update($data);
            return $tag;
        }
        return null;
    }

    public function delete(int $id): bool
    {
        $tag = Tag::find($id);
        if ($tag) {
            return $tag->delete();
        }
        return false;
    }
}
