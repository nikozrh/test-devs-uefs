<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
* @OA\Tag(
 *     name="Posts",
 *     description="São conteúdos criados pelos usuários para compartilhar informações, ideias ou qualquer tipo de mensagem. Cada postagem pode ser  associada a várias palavras-chave."
 * )
 * @OA\PathItem(
 *     path="/api/posts"
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
    *  @OA\Get(
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
        *                 @OA\Property(property="user_id", type="integer", example=1, description="ID do usuário"),
        *                 @OA\Property(property="title", type="string", example="Meu primeiro post", description="Título do post"),
        *                 @OA\Property(property="content", type="string", example="Conteúdo do meu post.", description="Conteúdo do post"),
        *                 @OA\Property(
        *                     property="tags",
        *                     type="array",
        *                     @OA\Items(type="integer", example=6),
        *                     description="IDs das tags associadas ao post"
        *                 )
        *             )
        *         )
        *     )
        * )
        */
    public function index()
    {
        try {

            $posts = $this->postService->getAllPosts();
    
            if ($posts->isEmpty()) {
                return response()->json([
                    'message' => 'Nenhum post encontrado.',
                ], 404); 
            }
    
            return response()->json($posts, 200); 
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Erro ao buscar os posts.',
                'error' => $e->getMessage(),
            ], 500); 
        }
    }

   /**
    *  @OA\Post(
     *     path="/api/posts",
     *     summary="Cadastrar post de um usuário com tags.",
     *     tags={"Posts"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"user_id", "title", "content"},
     *             @OA\Property(property="user_id", type="integer", example=1, description="ID do usuário"),
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
     *             @OA\Property(property="user_id", type="integer", example=1, description="ID do usuário"),
     *             @OA\Property(property="title", type="string", example="Meu primeiro post", description="Título do post"),
     *             @OA\Property(property="content", type="string", example="Conteúdo do meu post.", description="Conteúdo do post"),
     *             @OA\Property(
     *                 property="tags",
     *                 type="array",
     *                 @OA\Items(type="integer", example=6),
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
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'tags' => 'required|array|min:1', 
            'tags.*' => 'exists:tags,id',    
        ]);

        // Se houver erros de validação, retorna uma resposta com os erros
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $validator->errors()
            ], 422);
        }

        // Dados validados
        $validatedData = $validator->validated();

        // Chamar o serviço para criar o post
        try {
            $post = $this->postService->createPost($validatedData);

            return response()->json($post, 201); 
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar o post',
                'error' => $e->getMessage(),
            ], 500);
        } 
    }

   /**
    * @OA\Get(
        *     path="/api/posts/{post}",
        *     summary="Exibir post específico por ID.",
        *     tags={"Posts"},
        *     @OA\Parameter(
        *         name="post",
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
        *             @OA\Property(property="user_id", type="integer", example=1, description="ID do usuário"),
        *             @OA\Property(property="title", type="string", example="Meu primeiro post", description="Título do post"),
        *             @OA\Property(property="content", type="string", example="Conteúdo do meu post.", description="Conteúdo do post"),
        *             @OA\Property(
        *                 property="tags",
        *                 type="array",
        *                 @OA\Items(type="integer", example=6),
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
        */
    public function show($id)
    {
        $post = $this->postService->getPostById($id);
        return response()->json($post);
    }

    /**
     * @OA\Put(
        *     path="/api/posts/{post}",
        *     summary="Atualizar post específico.",
        *     tags={"Posts"},
        *     @OA\Parameter(
        *         name="post",
        *         in="path",
        *         required=true,
        *         description="ID do post",
        *         @OA\Schema(type="integer")
        *     ),
        *     @OA\RequestBody(
        *         required=true,
        *         @OA\JsonContent(
        *             type="object",
        *             required={"user_id", "title", "content"},
        *             @OA\Property(property="user_id", type="integer", example=1, description="ID do usuário"),
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
        *             @OA\Property(property="user_id", type="integer", example=1, description="ID do usuário"),
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
        */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'user_id' => 'sometimes|required|exists:users,id',
            'tags' => 'sometimes|array|min:1', 
            'tags.*' => 'exists:tags,id',    
        ]);

        // Se a validação falhar, retorna um erro
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $validator->errors()
            ], 422);
        }

        $validatedData = $validator->validated();
        
        // Chamar o serviço para atualizar o post
        try {
            $post = $this->postService->updatePost($id, $validatedData);
           
            if (!$post) {
                return response()->json([
                    'message' => 'Post não encontrado.',
                ], 404);
            }

            return response()->json($post, 200); 
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar o post',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Delete(
        *     path="/api/posts/{post}",
        *     summary="Remover post específico.",
        *     tags={"Posts"},
        *     @OA\Parameter(
        *         name="post",
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
    public function destroy($id)
    {
        $msg = 'Post deletado com sucesso.';
        $deleted = $this->postService->deletePost($id);
        return response()->json([ $msg => $deleted ], 204);
    }
}
