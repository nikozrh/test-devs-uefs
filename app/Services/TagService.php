<?php
namespace App\Services;

use App\Repositories\TagRepository;

class TagService
{
    protected $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function all()
    {
        return $this->tagRepository->all();
    }

    public function find($id)
    {
        return $this->tagRepository->find($id);
    }

    public function create(array $data)
    {
        $tag = $this->tagRepository->create($data);
        
        return [
            'status' => true,
            'message' => 'Tag cadastrada com sucesso',
            'tag' => $tag
        ];
    }

    public function update($id, array $data)
    {
        $tag = $this->tagRepository->update($id, $data);
    
        return [
            'status' => true,
            'message' => 'Tag atualizada com sucesso',
            'tag' => $tag
        ];
    }

    public function delete($id)
    {
        $this->tagRepository->delete($id);
        
        return [
            'status' => true,
            'message' => 'Tag excluída com sucesso'
        ]; 
    }
}