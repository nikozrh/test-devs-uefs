<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Post\Entities\Post;
use App\Domain\Post\Repositories\PostReadRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentPostReadRepository implements PostReadRepositoryInterface
{
    public function getAll(): Collection
    {
        return Post::with([
                'user:id,name,email',
                'tags:id,name'
            ])
            ->select(['id', 'title', 'content', 'user_id', 'created_at'])
            ->get();
    }

    public function findById(int $id): ?Post
    {
        return Post::with([
                'user:id,name,email',
                'tags:id,name'
            ])
            ->select(['id', 'title', 'content', 'user_id', 'created_at'])
            ->find($id);
    }
}
