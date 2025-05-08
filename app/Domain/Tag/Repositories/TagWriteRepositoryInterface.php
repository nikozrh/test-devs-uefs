<?php

namespace App\Domain\Tag\Repositories;

use App\Domain\Tag\Entities\Tag;

interface TagWriteRepositoryInterface
{
    public function create(array $data): Tag;
    public function update(int $id, array $data): ?Tag;
    public function delete(int $id): bool;
}
