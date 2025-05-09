<?php

namespace Tests\Unit\Application\Post;

use App\Application\Services\Post\GetPostService;
use App\Domain\Post\Entities\Post;
use App\Domain\Post\Repositories\PostReadRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class GetPostServiceTest extends TestCase
{
    private MockObject $readRepo;
    private GetPostService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->readRepo = $this->createMock(PostReadRepositoryInterface::class);
        $this->service = new GetPostService($this->readRepo);
    }

    public function test_findById_returns_post_if_exists(): void
    {
        $post = new Post(['id' => 1, 'title' => 'Hello', 'content' => 'World', 'user_id' => 1]);
        $this->readRepo->method('findById')->with(1)->willReturn($post);

        $result = $this->service->findById(1);
        $this->assertSame($post, $result);
    }

    public function test_findById_returns_null_if_not_exists(): void
    {
        $this->readRepo->method('findById')->with(999)->willReturn(null);
        $this->assertNull($this->service->findById(999));
    }

    public function test_getAll_returns_collection_of_posts(): void
    {
        $posts = new Collection([
            new Post(['id' => 1, 'title' => 'A', 'content' => 'X', 'user_id' => 1]),
            new Post(['id' => 2, 'title' => 'B', 'content' => 'Y', 'user_id' => 1]),
        ]);
        $this->readRepo->method('getAll')->willReturn($posts);

        $result = $this->service->getAll();
        $this->assertSame($posts, $result);
    }
}
