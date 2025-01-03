<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Eloquent\PostRepository;
use App\Models\Usuario;
use App\Models\Post;

class PostRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $postRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->postRepository = new PostRepository();
    }

    public function testGetAllPosts()
    {
        Post::factory()->count(3)->create();
        $posts = $this->postRepository->getAllPosts();

        $this->assertCount(3, $posts);
    }

    public function testGetPostById()
    {
        $post = Post::factory()->create();
        $retrievedPost = $this->postRepository->getPostById($post->id);

        $this->assertEquals($post->id, $retrievedPost->id);
    }

    public function testCreatePost()
    {
        $usuario = Usuario::factory()->create();
        $postData = [
            'usuario_id' => $usuario->id,
            'title' => 'Título post',
            'content' => 'Conteúdo post'
            ];
        $post = $this->postRepository->createPost($postData);

        $this->assertDatabaseHas('posts', ['content' => 'Conteúdo post']);
        $this->assertEquals($postData['title'], $post->title);
    }

    public function testUpdatePost()
    {
        $post = Post::factory()->create(['title' => 'Old Title']);
        $updatedData = ['title' => 'New Title'];

        $updatedPost = $this->postRepository->updatePost($post->id, $updatedData);

        $this->assertEquals('New Title', $updatedPost->title);
    }

    public function testDeletePost()
    {
        $post = Post::factory()->create();
        $result = $this->postRepository->deletePost($post->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
