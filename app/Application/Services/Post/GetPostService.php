<?php

namespace App\Application\Services\Post;

use App\Domain\Post\Entities\Post;
use App\Domain\Post\Repositories\PostReadRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GetPostService
{
    public function __construct(private PostReadRepositoryInterface $readRepo) {}

    public function findById(int $id): ?Post
    {
        return $this->readRepo->findById($id);
    }

    public function getAll(): Collection
    {
        return $this->readRepo->getAll();
    }
}