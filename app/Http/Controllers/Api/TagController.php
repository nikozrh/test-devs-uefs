<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Application\Services\Tag\GetTagService;
use App\Application\Services\Tag\CreateTagService;
use App\Application\Services\Tag\UpdateTagService;
use App\Application\Services\Tag\DeleteTagService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;

class TagController extends Controller
{
    public function __construct(
        private GetTagService $getService,
        private CreateTagService $createService,
        private UpdateTagService $updateService,
        private DeleteTagService $deleteService
    ) {}

    #[OA\Get(
        path: '/tags',
        summary: 'List all tags',
        tags: ['Tags'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Tag list returned successfully',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/Tag')
                )
            )
        ]
    )]
    public function index(): JsonResponse
    {
        $tags = $this->getService->getAll();

        return response()->json($tags, Response::HTTP_OK);
    }

    #[OA\Post(
        path: '/tags',
        summary: 'Create a new tag',
        tags: ['Tags'],
        requestBody: new OA\RequestBody(
            description: 'Tag data to create',
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/TagCreate')
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_CREATED,
                description: 'Tag created successfully',
                content: new OA\JsonContent(ref: '#/components/schemas/Tag')
            ),
            new OA\Response(
                response: Response::HTTP_UNPROCESSABLE_ENTITY,
                description: 'Validation error',
                content: new OA\JsonContent(ref: '#/components/schemas/ValidationError')
            )
        ]
    )]
    public function store(TagRequest $request): JsonResponse
    {
        $tag = $this->createService->execute($request->validated());

        return response()->json($tag, Response::HTTP_CREATED);
    }

    #[OA\Get(
        summary: 'Get tag details',
        tags: ['Tags'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Tag ID',
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Tag found',
                content: new OA\JsonContent(ref: '#/components/schemas/Tag')
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: 'Tag not found'
            )
        ]
    )]
    public function show(int $tag): JsonResponse
    {
        $model = $this->getService->findById($tag);

        return $model
            ? response()->json($model, Response::HTTP_OK)
            : response()->json(['message' => 'Tag not found'], Response::HTTP_NOT_FOUND);
    }

    #[OA\Put(
        path: '/tags/{id}',
        summary: 'Update a tag',
        tags: ['Tags'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Tag ID',
                schema: new OA\Schema(type: 'integer')
            )
        ],
        requestBody: new OA\RequestBody(
            description: 'Tag data to update',
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/TagUpdate')
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Tag updated successfully',
                content: new OA\JsonContent(ref: '#/components/schemas/Tag')
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: 'Tag not found'
            )
        ]
    )]
    public function update(TagRequest $request, int $tag): JsonResponse
    {
        $model = $this->updateService->execute($tag, $request->validated());

        return $model
            ? response()->json($model, Response::HTTP_OK)
            : response()->json(['message' => 'Tag not found'], Response::HTTP_NOT_FOUND);
    }

    #[OA\Delete(
        path: '/tags/{id}',
        summary: 'Delete a tag',
        tags: ['Tags'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Tag ID',
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Tag deleted successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string')
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: 'Tag not found'
            )
        ]
    )]
    public function destroy(int $tag): JsonResponse
    {
        $deleted = $this->deleteService->execute($tag);

        return $deleted
            ? response()->json(['message' => 'Tag deleted successfully'], Response::HTTP_OK)
            : response()->json(['message' => 'Tag not found'], Response::HTTP_NOT_FOUND);
    }
}
