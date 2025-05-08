<?php

namespace App\Application\Services\User;

use App\Domain\User\Repositories\UserWriteRepositoryInterface;
use App\Domain\User\Repositories\UserReadRepositoryInterface;

class DeleteUserService
{
    private UserWriteRepositoryInterface $userWriteRepository;
    private UserReadRepositoryInterface $userReadRepository; 

    public function __construct(
        UserWriteRepositoryInterface $userWriteRepository,
        UserReadRepositoryInterface $userReadRepository
    ) {
        $this->userWriteRepository = $userWriteRepository;
        $this->userReadRepository = $userReadRepository;
    }

    public function execute(string $userId): bool
    {
        $user = $this->userReadRepository->findById($userId);

        if (!$user) {
            return false; 
        }

        return $this->userWriteRepository->delete($userId);
    }
}
