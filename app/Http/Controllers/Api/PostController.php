<?php


namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\HelperApiController;

class PostController extends Controller
{
    /**
     * Retorna todas as postagens, incluindo suas tags associadas.
     * Rota: GET /api/posts
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retorna todas as postagens e inclui as tags associadas.
        return Post::with('tags')->get();
    }

    /**
     * Exibe os detalhes de uma postagem específica, incluindo suas tags.
     * Rota: GET /api/posts/{id}
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function show($id)
    {
        //Validar se a postagem existe
        if (Post::find($id) == null) {
            return HelperApiController::ExistText($id, 'posts');
        }

        // Encontra uma postagem pelo ID e inclui suas tags.
        return Post::with('tags')->findOrFail($id);
    }

    /**
     * Cria uma nova postagem no banco de dados.
     * Rota: POST /api/posts
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Verifico se existes tags a serem vinculadas a postagem. Se estão no formato correto e também se ela é existente.
        if ($request->has('tags')) {

            if (preg_match('/^\d+(,\d+)*$/', $request->tags) == 0)
                return HelperApiController::formatTag();

            foreach (explode(',', $request->tags) as $tag) {
                if (Tag::where('id', $tag)->pluck('name')->first() == NULL) {
                    return HelperApiController::ExistText($tag, 'tags');
                }
            }
        }

        // Validação
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
            // 'tags' => 'array', // Validar que tags seja um array
            'tags.*' => 'integer|exists:tags,id', // Validar que cada tag seja um ID existente na tabela tags
        ]);

        // Tratar erro de validação dos dados de entrada.
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Cria a postagem com os dados fornecidos.
        $post = Post::create($request->all());

        // Associar as tags
        if ($request->has('tags')) {
            $post->tags()->sync(explode(',', $request->tags));
        }

        return response()->json($post, 201);
    }


    /**
     * Atualiza uma postagem existente.
     * Rota: PUT /api/posts/{id}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validar se a postagem existe
        if (Post::find($id) == null) {
            return HelperApiController::ExistText($id, 'posts');
        }

        //Verifico se existes tags a serem vinculadas a postagem. Se estão no formato correto e também se ela é existente.
        if ($request->has('tags')) {          

            if (preg_match('/^\d+(,\d+)*$/', $request->tags) == 0)
                return HelperApiController::formatTag();

            foreach (explode(',', $request->tags) as $tag) {
                if (Tag::where('id', $tag)->pluck('name')->first() == NULL) {
                    return HelperApiController::ExistText($tag, 'tags');
                }
            }
        }

        // Encontra a postagem pelo ID ou lança uma exceção se não encontrada.
        $post = Post::findOrFail($id);

        // Atualiza a postagem com os novos dados fornecidos no request.
        $post->update($request->all());

        // Se o request contiver tags, atualiza a associação de tags da postagem.
        if ($request->has('tags')) {
            $post->tags()->sync(explode(',', $request->tags));  // Atualiza as tags associadas à postagem.
        }

        // Retorna a postagem atualizada.
        return response()->json($post);
    }

    /**
     * Exclui uma postagem pelo ID.
     * Rota: DELETE /api/posts/{id}
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         //Validar se a postagem existe
         if (Post::find($id) == null) {
            return HelperApiController::ExistText($id, 'posts');
        }

        // Encontra e deleta a postagem pelo ID.
        Post::findOrFail($id)->delete();

        // Retorna uma mensagem indicando que a postagem foi excluída com sucesso.
        return response()->json(['message' => 'Removido com sucesso!']);
    }
}
