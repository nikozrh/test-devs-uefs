<?php

namespace App\Application\Services\Tag;

use App\Domain\Tag\Entities\Tag;
use App\Domain\Tag\Repositories\TagReadRepositoryInterface;

class GetTagService
{
    public function __construct(private TagReadRepositoryInterface $readRepo) {}

    /**
     * Retrieve a single tag by ID.
     */
    public function findById(int $id): ?Tag
    {
        return $this->readRepo->findById($id);
    }

    /**
     * Retrieve all tags.
     */
    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->readRepo->getAll();
    }
}