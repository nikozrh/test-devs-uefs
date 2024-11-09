<?php
namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Retornar a lista de postagens
     * @return JsonResponse Retorna as postagens
     */
    public function index(): JsonResponse
    {
        DB::beginTransaction();
        try {
            $posts = $this->postService->all();
            DB::commit();

            return response()->json([
                'status' => true,
                'posts' => $posts
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'Ocorreu um erro ao buscar as postagens'
            ], 400);
        }
    }

    /**
     * Retornar uma postagem específica
     * @return JsonResponse Retorna uma postagem específica
     */
    public function show(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $post = $this->postService->find($request->id);
            DB::commit();

            return response()->json([
                'status' => true,
                'post' => $post
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'Postagem não encontrada.'
            ], 400);
        }
    }

    /**
     * Criar uma nova postagem
     * @return JsonResponse Retorna a postagem criada
     */
    public function store(PostRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $data = [
                'user_id' => $request->user_id,
                'title' => $request->title,
                'content' => $request->content,
            ];

            $result = $this->postService->create($data);
            DB::commit();

            if ($result['status']) {
                return response()->json([
                    'status' => $result['status'],
                    'post' => $result['post'],
                    'message' => $result['message']
                ], 201);
            } else {
                return response()->json([
                    'status' => $result['status'],
                    'message' => $result['message']
                ], 400);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Ocorreu um erro ao cadastrar a postagem'
            ], 400);
        }
    }

    /**
     * Atualizar uma postagem
     * @return JsonResponse Retorna a postagem atualizada
     */
    public function update(PostRequest $request, $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $data = [
                'user_id' => $request->user_id,
                'title' => $request->title,
                'content' => $request->content,
            ];

            $result = $this->postService->update($id, $data);
            DB::commit();

            if ($result['status']) {
                return response()->json([
                    'status' => $result['status'],
                    'post' => $result['post'],
                    'message' => $result['message']
                ], 200);
            } else {
                return response()->json([
                    'status' => $result['status'],
                    'message' => $result['message']
                ], 400);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Ocorreu um erro ao atualizar a postagem'
            ], 400);
        }
    }

    /**
     * Deletar uma postagem
     * @return JsonResponse Retorna a mensagem de sucesso ou erro
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $result = $this->postService->delete($id);
            DB::commit();

            if ($result['status']) {
                return response()->json([
                    'status' => $result['status'],
                    'message' => $result['message']
                ], 200);
            } else {
                return response()->json([
                    'status' => $result['status'],
                    'message' => $result['message']
                ], 400);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Ocorreu um erro ao excluir a postagem'
            ], 400);
        }
    }
}
