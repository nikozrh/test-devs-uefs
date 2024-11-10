<?php
namespace App\Services;

use App\Repositories\TagRepository;
use Illuminate\Support\Facades\Cache;

class TagService
{
    protected $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function all()
    {
        return Cache::remember('tags.all', 60, function () {
            return $this->tagRepository->all();
        });
    }

    public function find($id)
    {
        return $this->tagRepository->find($id);
    }

    public function create(array $data)
    {
        $tag = $this->tagRepository->create($data);

        Cache::forget('tags.all');

        return [
            'status' => true,
            'message' => 'Tag cadastrada com sucesso',
            'tag' => $tag
        ];
    }

    public function update($id, array $data)
    {
        $tag = $this->tagRepository->update($id, $data);

        Cache::forget('tags.all');

        return [
            'status' => true,
            'message' => 'Tag atualizada com sucesso',
            'tag' => $tag
        ];
    }

    public function delete($id)
    {
        $this->tagRepository->delete($id);

        Cache::forget('tags.all');

        return [
            'status' => true,
            'message' => 'Tag excluída com sucesso'
        ]; 
    }
}