<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository
{

    public function getAll()
    {
        return Tag::all();
    }

    public function getById($id)
    {
        return Tag::findOrFail($id);
    }

    public function create(array $data)
    {
        return Tag::create($data);
    }

    public function update(Tag $tag, array $data)
    {
        $tag->update($data);
        return $tag;
    }

    public function delete($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();
    }

    public function findById($id)
    {
        return Tag::find($id);
    }
}
