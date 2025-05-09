<?php

namespace App\Application\Services\Post;

use App\Domain\Post\Entities\Post;
use App\Domain\Post\Repositories\PostWriteRepositoryInterface;
use App\Domain\Post\Repositories\PostReadRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CreatePostService
{
    public function __construct(
        private PostWriteRepositoryInterface $writeRepo,
        private PostReadRepositoryInterface $readRepo
    ) {}

    public function execute(array $data): Post
    {
        return DB::transaction(function () use ($data) {
            $post = $this->writeRepo->create([ 
                'title'   => $data['title'],
                'content' => $data['content'],
                'user_id' => $data['user_id'],
            ]);

            if (!empty($data['tags'])) {
                $this->writeRepo->syncTags($post, $data['tags']);
            }

            return $this->readRepo->findById($post->id);
        });
    }
}