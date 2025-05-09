<?php

namespace App\Application\Services\User;

use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserWriteRepositoryInterface;
use Illuminate\Support\Facades\Hash; 

class CreateUserService
{
    private UserWriteRepositoryInterface $userWriteRepository;

    public function __construct(UserWriteRepositoryInterface $userWriteRepository)
    {
        $this->userWriteRepository = $userWriteRepository;
    }

    public function execute(array $data): User
    {
      

        $user = new User();
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']), 
        ];
        $user->fill($userData);

        return $this->userWriteRepository->save($user);
    }
}
