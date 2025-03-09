<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Services\TagService;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    // Listar todas as tags
    public function index()
    {
        return response()->json($this->tagService->getAllTags());
    }

    // Criar uma nova tag
    public function store(TagRequest $request)
    {
        $data = $request->validated();
        $tag = $this->tagService->createTag($data);
        return response()->json($tag, 201);
    }

    // Exibir uma tag específica
    public function show($id)
    {
        $tag = $this->tagService->getTagById($id);
        return response()->json($tag);
    }

    // Atualizar uma tag
    public function update(TagRequest $request, $id)
    {
        $data = $request->validated();
        $tag = $this->tagService->updateTag($id, $data);
        return response()->json($tag);
    }

    // Excluir uma tag
    public function destroy($id)
    {
        $msg = 'Tag deletada com sucesso.';
        $deleted = $this->tagService->deleteTag($id);
        return response()->json([ $msg => $deleted ], 204);
    }
}

