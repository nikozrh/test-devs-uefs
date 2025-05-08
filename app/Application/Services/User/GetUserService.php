<?php

namespace App\Application\Services\User;

use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserReadRepositoryInterface;

class GetUserService
{
    private UserReadRepositoryInterface $userReadRepository;

    public function __construct(UserReadRepositoryInterface $userReadRepository)
    {
        $this->userReadRepository = $userReadRepository;
    }

    public function findById(string $id): ?User
    {
        return $this->userReadRepository->findById($id);
    }

    public function getAll(array $filters = []): \Illuminate\Support\Collection
    {
        return $this->userReadRepository->getAll($filters);
    }
}
