<?php

namespace App\Application\Services\Post;

use App\Domain\Post\Repositories\PostWriteRepositoryInterface;

class DeletePostService
{
    public function __construct(private PostWriteRepositoryInterface $writeRepo) {}

    public function execute(int $id): bool
    {
        return $this->writeRepo->delete($id);
    }
}