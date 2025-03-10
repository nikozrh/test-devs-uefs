<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;

/**
* @OA\Info(
 *     version="1.0.0",
 *     title="Gerenciamento de Usuários, Postagens e Palavras-chave - API Blogsphere",
 *     description="Bem-vindo à documentação da API de Gerenciamento de Usuários, Postagens e Palavras-chave. 
 *     Esta API foi criada para oferecer uma solução eficiente para manipulação de dados relacionados a:
 *     USUÁRIOS: Cadastro e gerenciamento de usuários.
 *     POSTAGENS: Publicação e gerenciamento de postagens.
 *     PALAVRAS-CHAVES (Tags): Criação e associação de palavras-chave com postagens.
 *     
 *     GUIA DE USO SIMPLIFICADO:
 *     1. Cadastre um usuário no sistema.
 *     2. Crie uma ou mais tags conforme necessário.
 *     3. Publique uma postagem vinculada a pelo menos uma tag.",
 *     @OA\Contact(
 *         email="sandoelio@hotmail.com"
 *     )
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

        try {
            // Buscar todos os registros
            $items = $this->userService->getAllUsers();
    
            // Verificar se há itens na listagem
            if ($items->isEmpty()) {
                return response()->json([
                    'message' => 'Nenhum item encontrado.',
                ], 404);
            }
    
            return response()->json($items, 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar os itens.',
                'error' => $e->getMessage(),
            ], 500); 
        }
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
    public function store(Request $request) {

        // Validação dos dados recebidos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validatedData = $validator->validated();

        // Chamar o serviço para criar o usuário
        try {
            $user = $this->userService->createUser($validatedData);

            return response()->json($user, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar o usuário',
                'error' => $e->getMessage(),
            ], 500);
        }
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
    public function update(Request $request, $id) {
          
        $validator = Validator::make($request->all(), [

            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validatedData = $validator->validated();

        try {
            $user = $this->userService->updateUser($id, $validatedData);

            // Verificar se o usuário foi encontrado
            if (!$user) {
                return response()->json([
                    'message' => 'Usuário não encontrado.',
                ], 404);
            }

            return response()->json($user, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar o usuário',
                'error' => $e->getMessage(),
            ], 500);
        }
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

