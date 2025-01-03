<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{
    public function getAllPosts()
    {
        return Post::all()->load('tags')->load('usuario');
    }

    public function getPostById(int $id)
    {
        return Post::findOrFail($id);
    }

    public function createPost(array $data)
    {
        return Post::create($data);
    }

    public function updatePost(int $id, array $data)
    {
        $post = Post::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function deletePost(int $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return true;
    }
}
