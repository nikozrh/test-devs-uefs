<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Tag;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Retorna uma lista não paginada de posts
     *
     * Este método recupera uma lista não paginada de posts na base de dados
     * e a retorna como uma respota JSON.
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function index(): JsonResponse
    {
        // Recupera registros de posts, incluindo apenas as colunas 'id' e 'name' das tags, e oculta o campo 'pivot'
        $posts = Post::with(['tags:id,name'])->orderBy('created_at', 'DESC')->get();
    
        // Oculta o campo 'pivot' nas tags
        $posts->each(function ($post) {
            $post->tags->each(function ($tag) {
                $tag->makeHidden('pivot');
            });
        });
    
        // Retorna resposta em JSON dos registros de posts e suas tags
        return response()->json([
            'status' => true,
            'posts' => $posts
        ], 200);
    }

    /**
     * Exibe detalhes de um determinado post
     *
     * Este método os detalhes do registro de um post específico usando o ID como chave de referência
     * e retorna as informações de detalhes como uma respota JSON.
     *
     * @param \App\Models\Post $post O objeto do post a ser exibido
     * @return \Illuminate\Http\JsonResponse
    */    
    public function show(Post $post): JsonResponse
    {
        // Carrega as tags associadas ao post e oculta o campo 'pivot'
        $post->load(['tags:id,name']); // Eager loading das tags
    
        // Oculta o campo 'pivot' nas tags associadas ao post
        $post->tags->each(function ($tag) {
            $tag->makeHidden('pivot');
        });
    
        // Retorna os detalhes do post em formato JSON, incluindo as tags sem o 'pivot'
        return response()->json([
            'status' => true,
            'post' => $post
        ], 200);
    }
    
    /**
     * Cria post com os dados fornecidos na requisição
     *
     * @param \App\Http\Requests\PostRequest $request O objeto de requesição contendo os dados do post
     * a ser criado
     * @return \Illuminate\Http\JsonResponse
    */      
    public function store(PostRequest $request): JsonResponse
    {
        // Iniciando a transação
        DB::beginTransaction();
        try {
            // Criando o post
            $post = Post::create([
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => $request->user_id  
            ]);
    
            // Verificando se foram passadas tags e associando-as ao post
            if ($request->has('tags')) {
                // Associando as tags ao post
                $post->tags()->sync($request->tags); // A função sync associa as tags com o post
            }
    
            // Confirma o commit do novo registro
            DB::commit();
    
            // Retorna sucesso com os dados do post
            return response()->json([
                'status' => true,
                'message' => 'Post cadastrado com sucesso!',
                'post' => $post
            ], 201);
    
        } catch (Exception $e) {
            // Caso ocorra um erro, realiza o rollback
            DB::rollBack();
    
            // Retorna mensagem de erro
            return response()->json([
                'status' => false,
                'message' => 'Erro ao inserir novo post!',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Atualiza os dados de um determinado post com base nos dados fornecidos na requisição
     *
     * @param \App\Http\Requests\PostRequest $request O objeto de requesição contendo os dados do post
     * a ser atualizado
     * @param \App\Models\Post $post O post a ser atualizado
     * @return \Illuminate\Http\JsonResponse
    */    
    public function update(PostRequest $request, Post $post): JsonResponse
    {
        // Iniciar a transação
        DB::beginTransaction();
    
        try {
            // Editar o registro do post no banco de dados
            $post->update([
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => $request->user_id  
            ]);
    
            // Verificando se foram passadas novas tags e associando-as ao post
            if ($request->has('tags')) {
                // Sincronizando as tags com o post
                $post->tags()->sync($request->tags); // A função sync atualiza as tags associadas
            }
    
            // Confirma a transação
            DB::commit();
    
            // Retorna os dados do post editado e uma mensagem de sucesso com status 200
            return response()->json([
                'status' => true,
                'post' => $post,
                'message' => "Post atualizado com sucesso!",
            ], 200);
        } catch (Exception $e) {
            // Caso ocorra algum erro, realiza o rollback
            DB::rollBack();
    
            // Retorna uma mensagem de erro com status 400
            return response()->json([
                'status' => false,
                'message' => "Erro ao atualizar post!",
                'error' => $e->getMessage() // Retorna a mensagem de erro
            ], 400);
        }
    }

    /**
     * Delete de um determinado post no banco de dados
     *
     * @param \App\Models\Post $post O post a ser excluído
     * @return \Illuminate\Http\JsonResponse
    */
    public function destroy(Post $post): JsonResponse
    {
        DB::beginTransaction();
    
        try {
            // Excluindo o post
            $post->delete();
    
            // Confirma o commit do novo registro
            DB::commit();
    
            // Retorna resposta de sucesso
            return response()->json([
                'status' => true,
                'message' => 'Post excluido com sucesso!',
                'post' => $post
            ], 200);
    
        } catch (Exception $e) {
            // Caso aconteça algum erro, realiza o rollback
            DB::rollBack();
    
            // Retorna mensagem de erro
            return response()->json([
                'status' => false,
                'message' => 'Erro ao excluir post!'
            ], 400);
        }
    }
}