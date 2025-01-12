<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

class TagController extends Controller
{
    /**
     * Retorna uma lista não paginada de tags
     *
     * Este método recupera uma lista não paginada de tags na base de dados
     * e a retorna como uma respota JSON.
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function index() : JsonResponse
    {
                // Recupera registros de tags na entidade tags
                $tags = Tag::orderBy('created_at', 'DESC')->get();

                // Retorna resposta em JSON dos registros de tags recuperados
                return response()->json([
                    'status' => true,
                    'tags' => $tags
                ], 201);
    }

    /**
     * Exibe detalhes de uma determinada tag
     *
     * Este método exibe os detalhes do registro de uma tag específico usando o ID como chave de referência
     * e retorna as informações de detalhes como uma respota JSON.
     *
     * @param \App\Models\Tag $tag O objeto da tag a ser exibido
     * @return \Illuminate\Http\JsonResponse
    */    
    public function show(Tag $tag): JsonResponse
    {
        // Retorna detalhes de uma determinada tag em formato JSON
        return response()->json([
            'status' => true,
            'tags' => $tag
        ], 201);
    }
    
    /**
     * Cria tag com os dados fornecidos na requisição
     *
     * @param \App\Http\Requests\PostRequest $request O objeto de requesição contendo os dados da tag
     * a ser criado
     * @return \Illuminate\Http\JsonResponse
    */      
    public function store(TagRequest $request): JsonResponse
    {
        // Iniciando a transação
        DB::beginTransaction();
        try {
            // Criando o post
            $tag = Tag::create([
                'name' => $request->name 
            ]);
    
            // Confirma o commit do novo registro
            DB::commit();
    
            // Retorna sucesso com os dados da tag
            return response()->json([
                'status' => true,
                'message' => 'Tag cadastrada com sucesso!',
                'tag' => $tag
            ], 201);
    
        } catch (Exception $e) {
            // Caso ocorra um erro, realiza o rollback
            DB::rollBack();
    
            // Retorna mensagem de erro
            return response()->json([
                'status' => false,
                'message' => 'Erro ao inserir nova tag!',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Atualiza os dados de uma determinada tag com base nos dados fornecidos na requisição
     *
     * @param \App\Http\Requests\PostRequest $request O objeto de requesição contendo os dados da tag
     * a ser atualizada
     * @param \App\Models\Tag $post A tag a ser editada
     * @return \Illuminate\Http\JsonResponse
    */    
    public function update(TagRequest $request, Tag $tag): JsonResponse
    {
        // Iniciar a transação
        DB::beginTransaction();
    
        try {
            // Editar o registro do post no banco de dados
            $tag->update([
                'name' => $request->name 
            ]);
    
            // Confirma a transação
            DB::commit();
    
            // Retorna os dados da tag editada e uma mensagem de sucesso com status 200
            return response()->json([
                'status' => true,
                'tag' => $tag,
                'message' => "Tag atualizada com sucesso!",
            ], 200);
        } catch (Exception $e) {
            // Caso ocorra algum erro, realiza o rollback
            DB::rollBack();
    
            // Retorna uma mensagem de erro com status 400
            return response()->json([
                'status' => false,
                'message' => "Erro ao atualizar tag!",
                'error' => $e->getMessage() // Retorna a mensagem de erro
            ], 400);
        }
    }

    /**
     * Delete de uma determinada tag no banco de dados
     *
     * @param \App\Models\Tag $tag A tag a ser excluída
     * @return \Illuminate\Http\JsonResponse
    */
    public function destroy(TAg $tag): JsonResponse
    {
        DB::beginTransaction();
    
        try {
            // Excluindo o post
            $tag->delete();
    
            // Confirma o commit do novo registro
            DB::commit();
    
            // Retorna resposta de sucesso
            return response()->json([
                'status' => true,
                'message' => 'Tag excluida com sucesso!',
                'tag' => $tag
            ], 200);
    
        } catch (Exception $e) {
            // Caso aconteça algum erro, realiza o rollback
            DB::rollBack();
    
            // Retorna mensagem de erro
            return response()->json([
                'status' => false,
                'message' => 'Erro ao excluir tag!'
            ], 400);
        }
    }
}