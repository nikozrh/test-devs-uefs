<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * Retornar a lista de tags
     * @return JsonResponse Retorna as tags
     */
    public function index(): JsonResponse
    {
        DB::beginTransaction();
        try {
            $tags = $this->tagService->all();
            DB::commit();

            return response()->json([
                'status' => true,
                'tags' => $tags
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'Ocorreu um erro ao buscar as tags'
            ], 400);
        }
    }

    /**
     * Retornar uma tag específica
     * @return JsonResponse Retorna uma tag específica
     */
    public function show(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $tag = $this->tagService->find($request->id);
            DB::commit();

            return response()->json([
                'status' => true,
                'tag' => $tag
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'Tag não encontrada.'
            ], 400);
        }
    }

    /**
     * Criar uma nova tag
     * @return JsonResponse Retorna a tag criada
     */
    public function store(TagRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $data = [
                'post_id' => $request->post_id,
                'name' => $request->name,
            ];

            $result = $this->tagService->create($data);
            DB::commit();

            if ($result['status']) {
                return response()->json([
                    'status' => $result['status'],
                    'tag' => $result['tag'],
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
                'message' => 'Ocorreu um erro ao cadastrar a tag'
            ], 400);
        }
    }

    /**
     * Atualizar uma tag
     * @return JsonResponse Retorna a tag atualizada
     */
    public function update(TagRequest $request, $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $data = [
                'post_id' => $request->post_id,
                'name' => $request->name,
            ];

            $result = $this->tagService->update($id, $data);
            DB::commit();

            if ($result['status']) {
                return response()->json([
                    'status' => $result['status'],
                    'tag' => $result['tag'],
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
                'message' => 'Ocorreu um erro ao atualizar a tag'
            ], 400);
        }
    }

    /**
     * Deletar uma tag
     * @return JsonResponse Retorna a mensagem de sucesso ou erro
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $result = $this->tagService->delete($id);
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
                'message' => 'Ocorreu um erro ao excluir a tag'
            ], 400);
        }
    }
}