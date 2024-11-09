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

    public function all()
    {
        return $this->postRepository->all();
    }

    public function find($id)
    {
        return $this->postRepository->find($id);
    }

    public function create(array $data)
    {
        $post = $this->postRepository->create($data);

        return [
            'status' => true,
            'message' => 'Post cadastrado com sucesso.',
            'post' => $post,
        ];
    }

    public function update($id, array $data)
    {
        $post = $this->postRepository->update($id, $data);
        
        return [
            'status' => true,
            'message' => 'Post atualizado com sucesso',
            'post' => $post
        ];
    }

    public function delete($id)
    {
        $this->postRepository->delete($id);
    
        return [
            'status' => true,
            'message' => 'Post excluído com sucesso'
        ];
    }
}