<?php

namespace App\Application\Services\Post;

use App\Domain\Post\Entities\Post;
use App\Domain\Post\Repositories\PostWriteRepositoryInterface;
use App\Domain\Post\Repositories\PostReadRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UpdatePostService
{
    public function __construct(
        private PostWriteRepositoryInterface $writeRepo,
        private PostReadRepositoryInterface $readRepo
    ) {}

    public function execute(int $id, array $data): ?Post
    {
        return DB::transaction(function () use ($id, $data) {
            $post = $this->writeRepo->update($id, $data);
            if (!$post) {
                return null;
            }

            if (isset($data['tags'])) {
                $this->writeRepo->syncTags($post, $data['tags']);
            }

            return $this->readRepo->findById($id);
        });
    }
}