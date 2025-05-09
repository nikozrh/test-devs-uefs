<?php

namespace App\Domain\Post\Repositories;

use App\Domain\Post\Entities\Post;

interface PostWriteRepositoryInterface
{
    public function create(array $data): Post;
    public function update(int $id, array $data): ?Post;
    public function delete(int $id): bool;
    public function syncTags(Post $post, array $tags): void;
}
