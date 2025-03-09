<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Services\PostService;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    // Listar todos os posts
    public function index()
    {
        return response()->json($this->postService->getAllPosts());
    }

    // Criar um novo post
    public function store(PostRequest $request)
    {
        $data = $request->validated();
        $post = $this->postService->createPost($data);
        return response()->json($post, 201);
    }

    // Exibir um post específico
    public function show($id)
    {
        $post = $this->postService->getPostById($id);
        return response()->json($post);
    }

    // Atualizar um post
    public function update(PostRequest $request, $id)
    {
        $data = $request->validated();
        $post = $this->postService->updatePost($id, $data);
        return response()->json($post);
    }

    // Excluir um post
    public function destroy($id)
    {
        $msg = 'Post deletado com sucesso.';
        $deleted = $this->postService->deletePost($id);
        return response()->json([ $msg => $deleted ], 204);
    }
}
