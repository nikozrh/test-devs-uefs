<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository {
    
    public function getAll() {
        return User::all();
    }

    public function getById($id) {
        return User::findOrFail($id);
    }

    public function create(array $data) {
        return User::create($data);
    }

    public function update(User $user, array $data) {

        $user->update($data);
        return $user;
    }

    public function delete($id) {
        return User::destroy($id);
    }

    public function findById($id)
    {
        return User::find($id);
    }
}