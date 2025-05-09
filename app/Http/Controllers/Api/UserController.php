<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Domain\User\Repositories\UserReadRepositoryInterface;
use App\Domain\User\Repositories\UserWriteRepositoryInterface;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(
        private UserReadRepositoryInterface $userReadRepository,
        private UserWriteRepositoryInterface $userWriteRepository
    ) {
    }

    #[OA\Get(
        path: '/users',
        summary: 'Get list of users',
        tags: ['Users'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'User list retrieved successfully',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/User')
                )
            )
        ]
    )]
    public function index(): JsonResponse
    {
        $users = $this->userReadRepository->getAll();

        return response()->json($users, Response::HTTP_OK);
    }

    #[OA\Post(
        path: '/users',
        summary: 'Create a new user',
        tags: ['Users'],
        requestBody: new OA\RequestBody(
            description: 'User data for creation',
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/UserCreate')
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_CREATED,
                description: 'User created successfully',
                content: new OA\JsonContent(ref: '#/components/schemas/User')
            ),
            new OA\Response(
                response: Response::HTTP_UNPROCESSABLE_ENTITY,
                description: 'Validation error',
                content: new OA\JsonContent(ref: '#/components/schemas/ValidationError')
            )
        ]
    )]
    public function store(UserRequest $request): JsonResponse
    {
        $user = $this->userWriteRepository->create($request->validated());

        return response()->json($user, Response::HTTP_CREATED);
    }

    #[OA\Get(
        path: '/users/{id}',
        summary: 'Get user details',
        tags: ['Users'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'User ID',
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'User found',
                content: new OA\JsonContent(ref: '#/components/schemas/User')
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: 'User not found'
            )
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $user = $this->userReadRepository->findById($id);

        return $user
            ? response()->json(new UserResource($user), Response::HTTP_OK)
            : response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
    }

    #[OA\Put(
        path: '/users/{id}',
        summary: 'Update an existing user',
        tags: ['Users'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'User ID',
                schema: new OA\Schema(type: 'integer')
            )
        ],
        requestBody: new OA\RequestBody(
            description: 'User data for update',
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/UserUpdate')
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'User updated successfully',
                content: new OA\JsonContent(ref: '#/components/schemas/User')
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: 'User not found'
            ),
            new OA\Response(
                response: Response::HTTP_UNPROCESSABLE_ENTITY,
                description: 'Validation error',
                content: new OA\JsonContent(ref: '#/components/schemas/ValidationError')
            )
        ]
    )]
    public function update(UserRequest $request, int $id): JsonResponse
    {
        $user = $this->userWriteRepository->update($id, $request->validated());

        return $user
            ? response()->json(new UserResource($user), Response::HTTP_OK)
            : response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
    }

    #[OA\Delete(
        path: '/users/{id}',
        summary: 'Delete a user',
        tags: ['Users'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'User ID',
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'User deleted successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string')
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: 'User not found'
            )
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->userWriteRepository->delete($id);

        return $deleted
            ? response()->json(['message' => 'User deleted successfully'], Response::HTTP_OK)
            : response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
    }
}
