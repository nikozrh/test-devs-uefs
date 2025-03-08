<?php

namespace App\Services;

use App\Repositories\PostRepository;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAllPosts()
    {
        return $this->postRepository->getAll();
    }

    public function getPostById($id)
    {
        return $this->postRepository->getById($id);
    }

    public function createPost(array $data)
    {
        $post = $this->postRepository->create($data);

        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return $post->load('tags');
    }

    public function updatePost($id, array $data)
    {
        $post = $this->postRepository->update($id, $data);

        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return $post->load('tags');
    }

    public function deletePost($id)
    {
        return $this->postRepository->delete($id);
    }
}
