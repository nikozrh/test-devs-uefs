<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Services\PostService;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Protótipo de Rede Social",
 *     description="API protótipo de rede social."
 * )
 *
 * @OA\Tag(
 *     name="Posts",
 *     description="Operações relacionadas a posts."
 * )
 *
 * @OA\PathItem(
 *     path="/api/posts"
 * )
 *
 * @OA\Post(
 *     path="/api/posts",
 *     summary="Cadastrar post de um usuário com tags.",
 *     tags={"Posts"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"usuario_id", "title", "content"},
 *             @OA\Property(property="usuario_id", type="integer", example=1, description="ID do usuário"),
 *             @OA\Property(property="title", type="string", example="Meu primeiro post", description="Título do post"),
 *             @OA\Property(property="content", type="string", example="Conteúdo do meu post.", description="Conteúdo do post"),
 *             @OA\Property(
 *                 property="tags",
 *                 type="array",
 *                 @OA\Items(type="integer", example=6),
 *                 description="IDs das tags associadas ao post, começando do 1"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Post criado com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1, description="ID do post"),
 *             @OA\Property(property="usuario_id", type="integer", example=1, description="ID do usuário"),
 *             @OA\Property(property="title", type="string", example="Meu primeiro post", description="Título do post"),
 *             @OA\Property(property="content", type="string", example="Conteúdo do meu post.", description="Conteúdo do post"),
 *             @OA\Property(
 *                 property="tags",
 *                 type="array",
 *                 @OA\Items(type="integer", example=2),
 *                 description="IDs das tags associadas ao post"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Dados inválidos ou faltando parâmetros",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Erro ao criar o post.")
 *         )
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/posts",
 *     summary="Listar todos os posts com suas tags.",
 *     tags={"Posts"},
 *     @OA\Response(
 *         response=200,
 *         description="Lista de posts",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1, description="ID do post"),
 *                 @OA\Property(property="usuario_id", type="integer", example=1, description="ID do usuário"),
 *                 @OA\Property(property="title", type="string", example="Meu primeiro post", description="Título do post"),
 *                 @OA\Property(property="content", type="string", example="Conteúdo do meu post.", description="Conteúdo do post"),
 *                 @OA\Property(
 *                     property="tags",
 *                     type="array",
 *                     @OA\Items(type="integer", example=2),
 *                     description="IDs das tags associadas ao post"
 *                 )
 *             )
 *         )
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/posts/{id}",
 *     summary="Exibir post específico por ID.",
 *     tags={"Posts"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID do post",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Post encontrado",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1, description="ID do post"),
 *             @OA\Property(property="usuario_id", type="integer", example=1, description="ID do usuário"),
 *             @OA\Property(property="title", type="string", example="Meu primeiro post", description="Título do post"),
 *             @OA\Property(property="content", type="string", example="Conteúdo do meu post.", description="Conteúdo do post"),
 *             @OA\Property(
 *                 property="tags",
 *                 type="array",
 *                 @OA\Items(type="integer", example=2),
 *                 description="IDs das tags associadas ao post"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Post não encontrado",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Post não encontrado.")
 *         )
 *     )
 * )
 *
 * @OA\Put(
 *     path="/api/posts/{id}",
 *     summary="Atualizar post específico.",
 *     tags={"Posts"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID do post",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"usuario_id", "title", "content"},
 *             @OA\Property(property="usuario_id", type="integer", example=1, description="ID do usuário"),
 *             @OA\Property(property="title", type="string", example="Meu primeiro post", description="Título do post"),
 *             @OA\Property(property="content", type="string", example="Conteúdo do meu post.", description="Conteúdo do post"),
 *             @OA\Property(
 *                 property="tags",
 *                 type="array",
 *                 @OA\Items(type="integer", example=6),
 *                 description="IDs das tags associadas ao post, começando do 1"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Post atualizado com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1, description="ID do post"),
 *             @OA\Property(property="usuario_id", type="integer", example=1, description="ID do usuário"),
 *             @OA\Property(property="title", type="string", example="Meu primeiro post", description="Título do post"),
 *             @OA\Property(property="content", type="string", example="Conteúdo do meu post.", description="Conteúdo do post"),
 *             @OA\Property(
 *                 property="tags",
 *                 type="array",
 *                 @OA\Items(type="integer", example=2),
 *                 description="IDs das tags associadas ao post"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Dados inválidos ou faltando parâmetros",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Erro ao atualizar o post.")
 *         )
 *     )
 * )
 *
 * @OA\Delete(
 *     path="/api/posts/{id}",
 *     summary="Remover post específico.",
 *     tags={"Posts"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID do post",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Post deletado com sucesso"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Post não encontrado",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Post não encontrado.")
 *         )
 *     )
 * )
 */
class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->postService->getAllPosts();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $post = $this->postService->createPost($request->only('usuario_id', 'title', 'content'));
        
        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }
        
        return response()->json($post->load('tags')->load('usuario'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        
        $postEditing = $this->postService->updatePost($post->id, $request->only('usuario_id', 'title', 'content'));
        
        if ($request->has('tags')) {
            $postEditing->tags()->sync($request->tags);
        }

        return $postEditing->load('tags')->load('usuario');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        return $this->postService->deletePost($id);
    }
}
