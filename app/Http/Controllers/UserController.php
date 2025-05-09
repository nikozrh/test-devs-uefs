<?php

namespace App\Http\Controllers;

use App\Application\Services\User\CreateUserService;
use App\Application\Services\User\DeleteUserService;
use App\Application\Services\User\GetUserService;
use App\Application\Services\User\UpdateUserService;
use App\Domain\User\Entities\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest; 
use App\Http\Resources\UserResource; 
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private GetUserService $getUserService;
    private CreateUserService $createUserService;
    private UpdateUserService $updateUserService;
    private DeleteUserService $deleteUserService;

    public function __construct(
        GetUserService $getUserService,
        CreateUserService $createUserService,
        UpdateUserService $updateUserService,
        DeleteUserService $deleteUserService
    ) {
        $this->getUserService = $getUserService;
        $this->createUserService = $createUserService;
        $this->updateUserService = $updateUserService;
        $this->deleteUserService = $deleteUserService;
    }

    /**
     * List users with pagination.
     */
    public function index(): JsonResponse
    {
        $users = User::paginate(15);
        return UserResource::collection($users)->response();
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $user = $this->createUserService->execute($validatedData);
        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Get specific user by ID.
     */
    public function show(int $id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return (new UserResource($user))->response();
    }

    /**
     * Update existing user.
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $data = $request->validated();
        if (isset($data['name'])) {
            $user->name = $data['name'];
        }
        if (isset($data['email'])) {
            $user->email = $data['email'];
        }
        if (isset($data['password'])) {
            $user->password = bcrypt($data['password']);
        }
        $user->save();

        return (new UserResource($user))->response();
    }

    /**
     * Delete a user.
     */
    public function destroy(int $id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(null, 204);
    }
}
