<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\Usuario;
use App\Services\UsuarioService;

/**
 *
 * @OA\Tag(
 *     name="Usuários",
 *     description="Operações relacionadas a usuários."
 * )
 *
 * @OA\PathItem(
 *     path="/api/usuarios"
 * )
 *
 * @OA\Get(
 *     path="/api/usuarios",
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
 *                 @OA\Property(property="name", type="string", example="João", description="Nome do usuário"),
 *                 @OA\Property(property="email", type="string", example="joao@exemplo.com", description="Email do usuário"),
 *                 @OA\Property(property="password", type="string", example="xxsenha123", description="ID do usuário"),
 *                 @OA\Property(property="created_at", type="string", example="2025-01-02T20:00:39.000000Z", description="momento em que o registro foi criado no banco de dados."),
 *                 @OA\Property(property="updated_at", type="string", example="2025-01-02T20:00:39.000000Z", description="momento em que o registro foi atualizado pela última vez")
 *             )
 *         )
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/usuarios",
 *     summary="Cadastrar um novo usuário.",
 *     tags={"Usuários"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"name", "email", "password"},
 *             @OA\Property(property="name", type="string", example="João", description="Nome do usuário"),
 *             @OA\Property(property="email", type="string", example="joao@exemplo.com", description="Email do usuário"),
 *             @OA\Property(property="password", type="string", example="senha123", description="Senha do usuário")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Usuário criado com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1, description="ID do usuário"),
 *             @OA\Property(property="name", type="string", example="João", description="Nome do usuário"),
 *             @OA\Property(property="email", type="string", example="joao@exemplo.com", description="Email do usuário")
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
 * @OA\Get(
 *     path="/api/usuarios/{id}",
 *     summary="Exibir os dados de um usuário específico.",
 *     tags={"Usuários"},
 *     @OA\Parameter(
 *         name="id",
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
 *             @OA\Property(property="name", type="string", example="João", description="Nome do usuário"),
 *             @OA\Property(property="email", type="string", example="joao@exemplo.com", description="Email do usuário"),
 *             @OA\Property(property="password", type="string", example="xxsenha123", description="ID do usuário"),
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
 *
 * @OA\Put(
 *     path="/api/usuarios/{id}",
 *     summary="Atualizar os dados de um usuário específico.",
 *     tags={"Usuários"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID do usuário"
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="name", type="string", example="João", description="Nome do usuário"),
 *             @OA\Property(property="email", type="string", example="joao@exemplo.com", description="Email do usuário"),
 *             @OA\Property(property="password", type="string", example="senha123", description="Senha do usuário"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuário atualizado com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1, description="ID do usuário"),
 *             @OA\Property(property="name", type="string", example="João", description="Nome do usuário"),
 *             @OA\Property(property="email", type="string", example="joao@exemplo.com", description="Email do usuário"),
 *             @OA\Property(property="password", type="string", example="xxsenha123", description="ID do usuário"),
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
 *
 * @OA\Delete(
 *     path="/api/usuarios/{id}",
 *     summary="Deletar um usuário específico.",
 *     tags={"Usuários"},
 *     @OA\Parameter(
 *         name="id",
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
class UsuarioController extends Controller
{
    protected $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->usuarioService->getAllUsuarios();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUsuarioRequest $request)
    {
        return $this->usuarioService->createUsuario($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return $this->usuarioService->getUsuarioById($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUsuarioRequest $request, Usuario $usuario)
    {
        return $this->usuarioService->updateUsuario($usuario->id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        return $this->usuarioService->deleteUsuario($id);
    }
}
