<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Models\Tag;

class TagRepository implements TagRepositoryInterface
{
    public function getAllTags()
    {
        return Tag::all();
    }

    public function getTagById(int $id)
    {
        return Tag::findOrFail($id);
    }

    public function createTag(array $data)
    {
        return Tag::create($data);
    }

    public function updateTag(int $id, array $data)
    {
        $tag = Tag::findOrFail($id);
        $tag->update($data);
        return $tag;
    }

    public function deleteTag(int $id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();
        return true;
    }
}
