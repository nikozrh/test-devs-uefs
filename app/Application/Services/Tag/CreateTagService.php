<?php

namespace App\Application\Services\Tag;

use App\Domain\Tag\Entities\Tag;
use App\Domain\Tag\Repositories\TagWriteRepositoryInterface;

class CreateTagService
{
    public function __construct(private TagWriteRepositoryInterface $writeRepo) {}

    public function execute(array $data): Tag
    {
        return $this->writeRepo->create($data);
    }
}