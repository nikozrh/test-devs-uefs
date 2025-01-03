<?php

namespace App\Services;

use App\Repositories\Interfaces\PostRepositoryInterface;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAllPosts()
    {
        return $this->postRepository->getAllPosts();
    }

    public function getPostById(int $id)
    {
        return $this->postRepository->getPostById($id);
    }

    public function createPost(array $data)
    {
        return $this->postRepository->createPost($data);
    }

    public function updatePost(int $id, array $data)
    {
        return $this->postRepository->updatePost($id, $data);
    }

    public function deletePost(int $id)
    {
        return $this->postRepository->deletePost($id);
    }
}
