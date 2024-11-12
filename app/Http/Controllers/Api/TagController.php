<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    /**
     * Retorna todas as tags cadastradas.
     * Rota: GET /api/tags
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retorna todas as tags cadastradas no banco de dados.
        return Tag::all();
    }

    /**
     * Exibe os detalhes de uma tag específica.
     * Rota: GET /api/tags/{id}
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Validar se a tag existe
        if (Tag::find($id) == null) {
            return HelperApiController::ExistText($id, 'tags');
        }
        // Encontra e retorna uma tag pelo ID ou lança uma exceção se não encontrada.
        return Tag::findOrFail($id);
    }


    /**
     * Cria uma nova tag no banco de dados.
     * Rota: POST /api/tags
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valida os dados de entrada para garantir que o nome da tag seja único.
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:tags',  // Nome da tag é obrigatório e único.
        ]);

        // Tratar erro de validação dos dados de entrada.
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Cria a tag com o nome fornecido.
        $tag = Tag::create($request->all());

        // Retorna a tag criada com o código HTTP 201 (Created).
        return response()->json($tag, 201);
    }


    /**
     * Atualiza os dados de uma tag existente.
     * Rota: PUT /api/tags/{id}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        //Validar se a tag existe
        if (Tag::find($id) == null) {
            return HelperApiController::ExistText($id, 'tags');
        }

        // Valida os dados de entrada para garantir que o nome da tag seja único.
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:tags',  // Nome da tag é obrigatório e único.
        ]);

        // Tratar erro de validação dos dados de entrada.
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Encontra a tag pelo ID ou lança uma exceção se não encontrada.
        $tag = Tag::findOrFail($id);

        // Atualiza a tag com os novos dados fornecidos no request.
        $tag->update($request->all());

        // Retorna a tag atualizada.
        return response()->json($tag);
    }

    /**
     * Exclui uma tag pelo ID.
     * Rota: DELETE /api/tags/{id}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Validar se a tag existe
        if (Tag::find($id) == null) {
            return HelperApiController::ExistText($id, 'tags');
        }

        // Encontra e deleta a tag pelo ID.
        Tag::findOrFail($id)->delete();

        // Retorna uma mensagem indicando que a tag foi excluída com sucesso.
        return response()->json(['message' => 'Removido com sucesso!']);
    }
}
