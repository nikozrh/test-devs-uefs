<?php

namespace App\Services;

use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Cache;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function all()
    {
        return Cache::remember('posts.all', 60, function () {
            return $this->postRepository->all();
        });
    }

    public function find($id)
    {
        return $this->postRepository->find($id);
    }

    public function create(array $data)
    {
        $post = $this->postRepository->create($data);

        Cache::forget('posts.all');

        return [
            'status' => true,
            'message' => 'Post cadastrado com sucesso.',
            'post' => $post,
        ];
    }

    public function update($id, array $data)
    {
        $post = $this->postRepository->update($id, $data);

        Cache::forget('posts.all');

        return [
            'status' => true,
            'message' => 'Post atualizado com sucesso.',
            'post' => $post,
        ];
    }

    public function delete($id)
    {
        $this->postRepository->delete($id);

        Cache::forget('posts.all');

        return [
            'status' => true,
            'message' => 'Post deletado com sucesso.',
        ];
    }
}