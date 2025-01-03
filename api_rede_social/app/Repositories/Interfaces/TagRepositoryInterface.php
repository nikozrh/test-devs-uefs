<?php

namespace App\Repositories\Interfaces;

interface TagRepositoryInterface
{
    public function getAllTags();

    public function getTagById(int $id);

    public function createTag(array $data);

    public function updateTag(int $id, array $data);

    public function deleteTag(int $id);
}
