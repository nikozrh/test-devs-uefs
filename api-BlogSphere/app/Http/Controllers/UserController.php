<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;

class UserController extends Controller {

    protected $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function index() {
        return response()->json($this->userService->getAllUsers());
    }

    public function show($id) {
        return response()->json($this->userService->getUserById($id));
    }

    public function store(UserRequest $request) {

        return response()->json($this->userService->createUser($request->validated()), 201);
    }

    public function update(UserRequest $request, $id) {
        return response()->json($this->userService->updateUser($id, $request->validated()));
    }

    public function destroy($id) {
        $deleted = $this->userService->deleteUser($id);
        return response()->json(['deleted' => $deleted], 204);
    }
}

