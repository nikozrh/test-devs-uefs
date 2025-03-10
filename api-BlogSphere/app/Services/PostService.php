<?php

namespace App\Services;

use App\Repositories\PostRepository;
use Exception;

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
        try {
            // Cria o post no repositório
            $post = $this->postRepository->create($data);

            // Associa as tags ao post
            if (!empty($data['tags'])) {
                $this->postRepository->syncTags($post, $data['tags']);
            }

            return $post->load('tags'); // Retorna o post com as tags associadas
        } catch (Exception $e) {
            throw new Exception('Erro ao criar o post: ' . $e->getMessage());
        }    
    }

    public function updatePost($id, array $data)
    {
        try {
            // Buscar o post pelo ID
            $post = $this->postRepository->findById($id);
          
            if (!$post) {
                return null; // Post não encontrado
            }
    
            // Atualizar os dados do post
            $this->postRepository->update($post, $data);
    
            // Sincronizar as tags, se fornecidas
            if (isset($data['tags'])) {
                $this->postRepository->syncTags($post, $data['tags']);
            }
    
            return $post->load('tags'); // Retorna o post com as tags atualizadas
        } catch (\Exception $e) {
            throw new \Exception('Erro ao atualizar o post: ' . $e->getMessage());
        }
    }

    public function deletePost($id)
    {
        return $this->postRepository->delete($id);
    }
}
