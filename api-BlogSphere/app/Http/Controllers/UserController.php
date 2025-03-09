<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;

/**
* @OA\Info(
 * version="1.0.0",
 * title="Gerenciamento de Usuários, Postagens e Palavras-chave - Api Blogsphere",
 * description="Bem-vindo à documentação da API Gerenciamento de **Usuários**, **Postagens** e **Palavras-chave**, criada para oferecer uma solução eficiente para manipulação de dados relacionados a usuários, suas postagens e as palavras-chave associadas.
 * **Visão Geral**
 * Este sistema foi projetado para refletir uma estrutura hierárquica onde:
 * Essa API fornece endpoints para criar, ler, atualizar e deletar (CRUD) os dados de usuários, postagens e palavras-chave.",
 * )
 * @OA\Tag(
 *     name="Usuários",
 *     description="Representam indivíduos registrados no sistema. Cada usuário pode criar e gerenciar diferentes postagens."
 * )
 * @OA\PathItem(
 *     path="/api/users"
 * )
 */

class UserController extends Controller {

    protected $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

   /**
    * @OA\Get(
        *     path="/api/users",
        *     summary="Listar todos os usuários.",
        *     tags={"Usuários"},
        *     @OA\Response(
        *         response=200,
        *         description="Lista de usuários retornada com sucesso",
        *         @OA\JsonContent(
        *             type="array",
        *             @OA\Items(
        *                 type="object",
        *                 @OA\Property(property="id", type="integer", example=1, description="ID do usuário"),
        *                 @OA\Property(property="name", type="string", example="Camuel", description="Nome do usuário"),
        *                 @OA\Property(property="email", type="string", example="camuel@exemplo.com", description="Email do usuário"),
        *                 @OA\Property(property="password", type="string", example="12345678", description="ID do usuário"),
        *                 @OA\Property(property="created_at", type="string", example="2025-01-02T20:00:39.000000Z", description="momento em que o registro foi criado no banco de dados."),
        *                 @OA\Property(property="updated_at", type="string", example="2025-01-02T20:00:39.000000Z", description="momento em que o registro foi atualizado pela última vez")
        *             )
        *         )
        *     )
        * )
        *
        */

    public function index() {
        return response()->json($this->userService->getAllUsers());
    }

    /**
    * @OA\Get(
     *     path="/api/users/{user}",
     *     summary="Exibir os dados de um usuário específico.",
     *     tags={"Usuários"},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID do usuário"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário encontrado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1, description="ID do usuário"),
     *             @OA\Property(property="name", type="string", example="Camuel", description="Nome do usuário"),
     *             @OA\Property(property="email", type="string", example="camuel@exemplo.com", description="Email do usuário"),
     *             @OA\Property(property="created_at", type="string", example="2025-01-02T20:00:39.000000Z", description="momento em que o registro foi criado no banco de dados."),
     *             @OA\Property(property="updated_at", type="string", example="2025-01-02T20:00:39.000000Z", description="momento em que o registro foi atualizado pela última vez")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Usuário não encontrado.")
     *         )
     *     )
     * )
     */


    public function show($id) {
        return response()->json($this->userService->getUserById($id));
    }

    /**
    * @OA\Post(
     *     path="/api/users",
     *     summary="Cadastrar um novo usuário.",
     *     tags={"Usuários"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="Camuel", description="Nome do usuário"),
     *             @OA\Property(property="email", type="string", example="camuel@exemplo.com", description="Email do usuário"),
     *             @OA\Property(property="password", type="string", example="12345678", description="Senha do usuário")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuário criado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1, description="ID do usuário"),
     *             @OA\Property(property="name", type="string", example="Camuel", description="Nome do usuário"),
     *             @OA\Property(property="email", type="string", example="camuel@exemplo.com", description="Email do usuário")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dados inválidos ou faltando parâmetros",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Erro ao criar o usuário.")
     *         )
     *     )
     * )
     *
     */
    public function store(UserRequest $request) {

        return response()->json($this->userService->createUser($request->validated()), 201);
    }

    /**
    * @OA\Put(
     *     path="/api/users/{user}",
     *     summary="Atualizar os dados de um usuário específico.",
     *     tags={"Usuários"},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID do usuário"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Camuel", description="Nome do usuário"),
     *             @OA\Property(property="email", type="string", example="camuel@exemplo.com", description="Email do usuário"),
     *             @OA\Property(property="password", type="string", example="12345678", description="Senha do usuário"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário atualizado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1, description="ID do usuário"),
     *             @OA\Property(property="name", type="string", example="Camuel", description="Nome do usuário"),
     *             @OA\Property(property="email", type="string", example="camuel@exemplo.com", description="Email do usuário"),
     *             @OA\Property(property="password", type="string", example="12345678", description="ID do usuário"),
     *             @OA\Property(property="created_at", type="string", example="2025-01-02T20:00:39.000000Z", description="momento em que o registro foi criado no banco de dados."),
     *             @OA\Property(property="updated_at", type="string", example="2025-01-02T20:00:39.000000Z", description="momento em que o registro foi atualizado pela última vez")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dados inválidos ou faltando parâmetros",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Erro ao atualizar o usuário.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="ID inválido. Usuário não encontrado.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="O usuário não existe.")
     *         )
     *     )
     * )
     */
    public function update(UserRequest $request, $id) {
        return response()->json($this->userService->updateUser($id, $request->validated()));
    }

    /**
    * @OA\Delete(
        *     path="/api/users/{user}",
        *     summary="Deletar um usuário específico.",
        *     tags={"Usuários"},
        *     @OA\Parameter(
        *         name="user",
        *         in="path",
        *         required=true,
        *         @OA\Schema(type="integer"),
        *         description="ID do usuário"
        *     ),
        *     @OA\Response(
        *         response=204,
        *         description="Usuário deletado com sucesso"
        *     ),
        *     @OA\Response(
        *         response=404,
        *         description="Usuário não encontrado",
        *         @OA\JsonContent(
        *             type="object",
        *             @OA\Property(property="error", type="string", example="Usuário não encontrado.")
        *         )
        *     )
        * )
        */
    public function destroy($id) {
        $deleted = $this->userService->deleteUser($id);
        return response()->json(['deleted' => $deleted], 204);
    }
}

