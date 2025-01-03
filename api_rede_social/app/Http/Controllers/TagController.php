<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use App\Services\TagService;

/**
 *
 * @OA\Tag(
 *     name="Tags",
 *     description="Operações relacionadas a tags."
 * )
 *
 * @OA\Get(
 *     path="/api/tags",
 *     summary="Listar todas as tags.",
 *     tags={"Tags"},
 *     @OA\Response(
 *         response=200,
 *         description="Lista de tags retornada com sucesso",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1, description="ID da tag"),
 *                 @OA\Property(property="name", type="string", example="Tecnologia", description="Nome da tag")
 *             )
 *         )
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/tags",
 *     summary="Cadastrar uma nova tag.",
 *     tags={"Tags"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="Tecnologia", description="Nome da tag")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Tag criada com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1, description="ID da tag"),
 *             @OA\Property(property="name", type="string", example="Tecnologia", description="Nome da tag")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Dados inválidos ou faltando parâmetros",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Erro ao criar a tag.")
 *         )
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/tags/{id}",
 *     summary="Exibir os dados de uma tag específica.",
 *     tags={"Tags"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID da tag"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Tag encontrada com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1, description="ID da tag"),
 *             @OA\Property(property="name", type="string", example="Tecnologia", description="Nome da tag")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Tag não encontrada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Tag não encontrada.")
 *         )
 *     )
 * )
 *
 * @OA\Put(
 *     path="/api/tags/{id}",
 *     summary="Atualizar os dados de uma tag específica.",
 *     tags={"Tags"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID da tag"
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="name", type="string", example="Tecnologia", description="Nome da tag")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Tag atualizada com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1, description="ID da tag"),
 *             @OA\Property(property="name", type="string", example="Tecnologia", description="Nome da tag")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Dados inválidos ou faltando parâmetros",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Erro ao atualizar a tag.")
 *         )
 *     )
 * )
 *
 * @OA\Delete(
 *     path="/api/tags/{id}",
 *     summary="Deletar uma tag específica.",
 *     tags={"Tags"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID da tag"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Tag deletada com sucesso"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Tag não encontrada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Tag não encontrada.")
 *         )
 *     )
 * )
 */
class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->tagService->getAllTags();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request)
    {
        return $this->tagService->createTag($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return $this->tagService->getTagById($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        return $this->tagService->updateTag($tag->id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        return $this->tagService->deleteTag($id);
    }
}
