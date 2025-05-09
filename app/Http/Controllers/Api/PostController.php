<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Domain\Post\Repositories\PostReadRepositoryInterface;
use App\Domain\Post\Repositories\PostWriteRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Domain\Post\Entities\Post;
use OpenApi\Attributes as OA;

class PostController extends Controller
{
    public function __construct(
        private PostReadRepositoryInterface $postReadRepository,
        private PostWriteRepositoryInterface $postWriteRepository
    ) {}

    #[OA\Get(
        path: '/posts',
        summary: 'List all posts',
        tags: ['Posts'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Posts retrieved successfully',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/Post')
                )
            )
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) min($request->get('per_page', 15), 100);

        $posts = Post::with([
                'user:id,name,email',
                'tags:id,name'
            ])
            ->select(['id', 'title', 'content', 'user_id', 'created_at'])
            ->paginate($perPage);

        return response()->json($posts);
    }

    #[OA\Post(
        path: '/posts',
        summary: 'Create a new post',
        tags: ['Posts'],
        requestBody: new OA\RequestBody(
            description: 'Post data to be created',
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/PostCreate')
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Post created successfully',
                content: new OA\JsonContent(ref: '#/components/schemas/Post')
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                content: new OA\JsonContent(ref: '#/components/schemas/ValidationError')
            ),
            new OA\Response(
                response: 500,
                description: 'Internal server error'
            )
        ]
    )]
    public function store(PostRequest $request): JsonResponse
    {
        $validated = $request->validated();

        try {
            $post = DB::transaction(function () use ($validated) {
                $post = $this->postWriteRepository->create($validated);

                if (isset($validated['tags'])) {
                    $this->postWriteRepository->syncTags($post, $validated['tags']);
                }
                return $post->load('user', 'tags');
            });

            return response()->json($post, 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error creating the post.'], 500);
        }
    }

    #[OA\Get(
        path: '/posts/{id}',
        summary: 'Get post details',
        tags: ['Posts'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Post ID',
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Post found',
                content: new OA\JsonContent(ref: '#/components/schemas/Post')
            ),
            new OA\Response(
                response: 404,
                description: 'Post not found'
            )
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $post = $this->postReadRepository->findById($id);

        return $post
            ? response()->json($post)
            : response()->json(['message' => 'Post not found'], 404);
    }

    #[OA\Put(
        path: '/posts/{id}',
        summary: 'Update a post',
        tags: ['Posts'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Post ID',
                schema: new OA\Schema(type: 'integer')
            )
        ],
        requestBody: new OA\RequestBody(
            description: 'Post data to be updated',
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/PostUpdate')
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Post updated successfully',
                content: new OA\JsonContent(ref: '#/components/schemas/Post')
            ),
            new OA\Response(
                response: 404,
                description: 'Post not found'
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                content: new OA\JsonContent(ref: '#/components/schemas/ValidationError')
            ),
            new OA\Response(
                response: 500,
                description: 'Internal server error'
            )
        ]
    )]
    public function update(PostRequest $request, int $id): JsonResponse
    {
        $validated = $request->validated();

        try {
            $post = DB::transaction(function () use ($id, $validated) {
                $postInstance = $this->postWriteRepository->update($id, $validated);

                if (!$postInstance) {
                    return null; // handled below
                }

                if (isset($validated['tags'])) {
                    $this->postWriteRepository->syncTags($postInstance, $validated['tags']);
                }
                return $postInstance->load('user', 'tags');
            });

            if (!$post) {
                return response()->json(['message' => 'Post not found'], 404);
            }

            return response()->json($post);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error updating the post.'], 500);
        }
    }

    #[OA\Delete(
        path: '/posts/{id}',
        summary: 'Delete a post',
        tags: ['Posts'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Post ID',
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Post deleted successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string')
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Post not found'
            )
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $result = $this->postWriteRepository->delete($id);

        return $result
            ? response()->json(['message' => 'Post deleted successfully'])
            : response()->json(['message' => 'Post not found'], 404);
    }
}
