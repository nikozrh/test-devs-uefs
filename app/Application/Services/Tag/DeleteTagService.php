<?php

namespace App\Application\Services\Tag;

class DeleteTagService
{
    public function __construct(private \App\Domain\Tag\Repositories\TagWriteRepositoryInterface $writeRepo) {}

    public function execute(int $id): bool
    {
        return $this->writeRepo->delete($id);
    }
}