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

    public function getAllTags()
    {
        return $this->tagRepository->getAll();
    }

    public function getTagById($id)
    {
        return $this->tagRepository->getById($id);
    }

    public function createTag(array $data)
    {
        return $this->tagRepository->create($data);
    }

    public function updateTag($id, array $data)
    {
        $tag = $this->tagRepository->findById($id);

        if (!$tag) {
            return null; // Tag não encontrada
        }

        // Atualizar a tag no repositório
        return $this->tagRepository->update($tag, $data);
    }

    public function deleteTag($id)
    {
        return $this->tagRepository->delete($id);
    }
}
