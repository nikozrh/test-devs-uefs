<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Retorna uma lista não paginada de usuários
     *
     * Este método recupera uma lista não paginada de usuários na base de dados
     * e a retorna como uma respota JSON.
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function index() : JsonResponse
    {
        // Recupera registros de usuários na entidade User
        $users = User::orderBy('name', 'ASC')->get();

        // Retorna resposta em JSON dos registros de usuários recuperados
        return response()->json([
            'status' => true,
            'users' => $users
        ], 201);
    }

    /**
     * Exibe detalhes de um determinado usuário
     *
     * Este método os detalhes do registro de um usuário específico usando o ID como chave de referência
     * e retorna as informações de detalhes como uma respota JSON.
     *
     * @param \App\Models\User $user O objeto do usuário a ser exibido
     * @return \Illuminate\Http\JsonResponse
    */    
    public function show(User $user) : JsonResponse
    {
        // Retorna detalhes de um determinado usuário em formato JSON
        return response()->json([
            'status' => true,
            'users' => $user
        ], 201);
    }

    /**
     * Cria usuário com os dados fornecidos na requisição
     *
     * @param \App\Http\Requests\UserRequest $request O objeto de requesição contendo os dados do usuário
     * a ser criado
     * @return \Illuminate\Http\JsonResponse
    */    
    public function store(UserRequest $request): JsonResponse
    {
        // Iniciando a transação
        DB::beginTransaction();

        try{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password, ['rounds' => 12])    
            ]);

            // Confirma o commit do novo registro
            DB::commit();

            // Retorna mensagem de erro
            return response()->json([
                'status' => true,
                'message' => 'Usuário cadastrado com sucesso!',
                'user' => $user
            ], 201);

        }catch (Exception $e){
            // Operação não concluída
            DB::rollBack();

            // Retorna mensagem de erro
            return response()->json([
                'status' => false,
                'message' => 'Erro ao inserir novo usuário!'
            ], 400);
        }
    }

    /**
     * Atualiza os dados de um determinado usuário com base nos dados fornecidos na requisição
     *
     * @param \App\Http\Requests\UserRequest $request O objeto de requesição contendo os dados do usuário
     * a ser atualizado
     * @param \App\Models\User $user O usuário a ser atualizado
     * @return \Illuminate\Http\JsonResponse
    */
    public function update(UserRequest $request, User $user): JsonResponse
    {

        // Iniciar a transação
        DB::beginTransaction();

        try {

            // Editar o registro no banco de dados
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password, ['rounds' => 12])    
            ]);

            // Operação é concluída com êxito
            DB::commit();

            // Retorna os dados do usuário editado e uma mensagem de sucesso com status 200
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => "Usuário atualizado com sucesso!",
            ], 200);
        } catch (Exception $e) {

            // Operação não é concluída com êxito
            DB::rollBack();

            // Retorna uma mensagem de erro com status 400
            return response()->json([
                'status' => false,
                'message' => "Erro ao atualizar usuário!",
            ], 400);
        }
    }

    /**
     * Delete de um determinado usuário no banco de dados
     *
     * @param \App\Models\User $user O usuário a ser excluído
     * @return \Illuminate\Http\JsonResponse
    */
    public function destroy(User $user): JsonResponse
    {
        DB::beginTransaction();
    
        try {
            // Excluindo o usuário
            $user->delete();
    
            // Confirma o commit do novo registro
            DB::commit();
    
            // Retorna resposta de sucesso
            return response()->json([
                'status' => true,
                'message' => 'Usuário excluido com sucesso!',
                'user' => $user
            ], 200);
    
        } catch (Exception $e) {
            // Caso aconteça algum erro, realiza o rollback
            DB::rollBack();
    
            // Retorna mensagem de erro
            return response()->json([
                'status' => false,
                'message' => 'Erro ao excluir usuário!'
            ], 400);
        }
    }
    
}
