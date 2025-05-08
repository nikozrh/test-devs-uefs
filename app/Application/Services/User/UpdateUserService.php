<?php

namespace App\Application\Services\User;

use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserWriteRepositoryInterface;
use App\Domain\User\Repositories\UserReadRepositoryInterface;
use Illuminate\Support\Facades\Hash; 

class UpdateUserService
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

    public function execute(string $userId, array $data): ?User
    {
        $user = $this->userReadRepository->findById($userId);

        if (!$user) {
            return null; 
        }

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userWriteRepository->update($user, $data);
    }
}
