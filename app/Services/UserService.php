<?php
namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Cache;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function all()
    {
        return Cache::remember('users.all', 60, function () {
            return $this->userRepository->all();
        });
    }

    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    public function store(array $data)
    { 
        $user = $this->userRepository->create($data);

        Cache::forget('users.all');
        
        return [
            'status' => true,
            'message' => 'Usuário cadastrado com sucesso.',
            'user' => $user,
        ];
    }

    public function update($id, array $data)
    {
        $user = $this->userRepository->update($id, $data);

        Cache::forget('users.all');

        return [
            'status' => true,
            'message' => 'Usuário atualizado com sucesso',
            'user' => $user
        ];
    }

    public function destroy($id)
    {
        $this->userRepository->delete($id);

        Cache::forget('users.all');

        return [
            'status' => true,
            'message' => 'Usuário excluído com sucesso'
        ];
    }
}