<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Post\Entities\Post;
use App\Domain\Post\Repositories\PostWriteRepositoryInterface;

class EloquentPostWriteRepository implements PostWriteRepositoryInterface
{
    public function create(array $data): Post
    {
        return Post::create($data);
    }

    public function update(int $id, array $data): ?Post
    {
        $post = Post::find($id);
        if ($post) {
            $post->update($data);
            return $post;
        }
        return null;
    }

    public function delete(int $id): bool
    {
        $post = Post::find($id);
        if ($post) {
            return $post->delete();
        }
        return false;
    }

    public function syncTags(Post $post, array $tags): void
    {
        $post->tags()->sync($tags);
    }
}
