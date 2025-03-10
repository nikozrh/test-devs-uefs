<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService {
    
    protected $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers() {
        return $this->userRepository->getAll();
    }

    public function getUserById($id) {
        return $this->userRepository->getById($id);
    }

    public function createUser(array $data) {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->create($data);
    }

    public function updateUser($id, array $data) {
  
        $user = $this->userRepository->findById($id);

        if (!$user) {
            return null; 
        }

        // Atualizar a senha apenas se for enviada
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->update($user, $data);
    }

    public function deleteUser($id) {
        return $this->userRepository->delete($id);
    }
}
