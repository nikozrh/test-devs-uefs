<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    } 

    public function getAll()
    {
        return Post::with('tags', 'user')->get();
    }

    public function getById($id)
    {
        return Post::with('tags', 'user')->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->post->create([
            'title' => $data['title'],
            'content' => $data['content'],
            'user_id' => $data['user_id'],
        ]);
    }

    public function update(Post $post, array $data)
    {
        $post->update($data);
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
    }

    // Sincroniza as tags do post
    public function syncTags(Post $post, array $tags)
    {
        $post->tags()->sync($tags);
    }

    public function findById($id)
    {
        return Post::find($id); 
    }
}
