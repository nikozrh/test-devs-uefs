<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Mockery;
use App\Services\PostService;
use App\Repositories\Interfaces\PostRepositoryInterface;

class PostServiceTest extends TestCase
{
    protected $postService;
    protected $postRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock do PostRepositoryInterface
        $this->postRepositoryMock = Mockery::mock(PostRepositoryInterface::class);
        $this->postService = new PostService($this->postRepositoryMock);
    }

    public function testGetAllPosts()
    {
        $posts = [
            ['id' => 1, 'title' => 'Título post 1', 'content' => 'Conteúdo post 1'],
            ['id' => 2, 'title' => 'Título post 2', 'content' => 'Conteúdo post 2']
        ];

        $this->postRepositoryMock
            ->shouldReceive('getAllPosts')
            ->once()
            ->andReturn($posts);

        $result = $this->postService->getAllPosts();
        $this->assertEquals($posts, $result);
    }

    public function testCreatePost()
    {
        $postData = ['title' => 'Título post', 'content' => 'Conteúdo post'];
        $createdPost = ['id' => 1, 'title' => 'Título post', 'content' => 'Conteúdo post'];

        $this->postRepositoryMock
            ->shouldReceive('createPost')
            ->once()
            ->with($postData)
            ->andReturn($createdPost);

        $result = $this->postService->createPost($postData);
        $this->assertEquals($createdPost, $result);
    }

    public function testDeletePost()
    {
        $postId = 1;

        $this->postRepositoryMock
            ->shouldReceive('deletePost')
            ->once()
            ->with($postId)
            ->andReturn(true);

        $result = $this->postService->deletePost($postId);
        $this->assertTrue($result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
