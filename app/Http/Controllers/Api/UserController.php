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
        $users = User::orderBy('name', 'ASC')->get();

        return response()->json([
            'status' => true,
            'users' => $users
        ], 200);
    }

    /**
     * Exibe detalhes de um determinado usuário
     *
     * Este método os detalhes do registro de um usuário específico usando o ID como chave de referência
     * e retorna as informações de detalhes como uma respota JSON.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user) : JsonResponse
    {
        return response()->json([
            'status' => true,
            'user' => $user
        ], 200);
    }

    /**
     * Cria um novo usuário
     *
     * @param \App\Http\Requests\UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password, ['rounds' => 12])
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Usuário cadastrado com sucesso!',
                'user' => $user
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Erro ao inserir novo usuário!'
            ], 400);
        }
    }

    /**
     * Atualiza os dados de um determinado usuário
     *
     * @param \App\Http\Requests\UserRequest $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, User $user): JsonResponse
    {
        DB::beginTransaction();

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password, ['rounds' => 12])
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => "Usuário atualizado com sucesso!",
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => "Erro ao atualizar usuário!",
            ], 400);
        }
    }

    /**
     * Exclui um usuário
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        DB::beginTransaction();

        try {
            $user->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Usuário excluído com sucesso!',
                'user' => $user
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Erro ao excluir usuário!'
            ], 400);
        }
    }
}
