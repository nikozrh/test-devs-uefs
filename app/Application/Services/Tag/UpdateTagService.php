<?php

namespace App\Application\Services\Tag;

use App\Domain\Tag\Entities\Tag;
use App\Domain\Tag\Repositories\TagWriteRepositoryInterface;

class UpdateTagService
{
    public function __construct(private TagWriteRepositoryInterface $writeRepo) {}

    public function execute(int $id, array $data): ?Tag
    {
        return $this->writeRepo->update($id, $data);
    }
}