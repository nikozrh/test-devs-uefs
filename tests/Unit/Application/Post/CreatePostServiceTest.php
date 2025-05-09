<?php

namespace Tests\Unit\Application\Post;

use App\Application\Services\Post\CreatePostService;
use App\Domain\Post\Entities\Post;
use App\Domain\Post\Repositories\PostWriteRepositoryInterface;
use App\Domain\Post\Repositories\PostReadRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class CreatePostServiceTest extends TestCase
{
    private MockObject $writeRepo;
    private MockObject $readRepo;
    private CreatePostService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->writeRepo = $this->createMock(PostWriteRepositoryInterface::class);
        $this->readRepo = $this->createMock(PostReadRepositoryInterface::class);
        $this->service = new CreatePostService($this->writeRepo, $this->readRepo);
    }

    public function test_execute_creates_and_returns_post(): void
    {
        $data = ['title' => 'Test', 'content' => 'Content', 'user_id' => 1, 'tags' => [1, 2]];
        $post = new Post(['id' => 1, 'title' => 'Test', 'content' => 'Content', 'user_id' => 1]);
        $post->id = 1;

        DB::shouldReceive('transaction')->once()->andReturnUsing(function ($callback) use ($post, $data) {
            $this->writeRepo->expects($this->once())
                ->method('create')
                ->with([
                    'title'   => $data['title'],
                    'content' => $data['content'],
                    'user_id' => $data['user_id'],
                ])
                ->willReturn($post);

            $this->writeRepo->expects($this->once())
                ->method('syncTags')
                ->with($post, $data['tags']);

            $this->readRepo->expects($this->once())
                ->method('findById')
                ->with($post->id)
                ->willReturn($post);

            return $callback();
        });

        $result = $this->service->execute($data);
        $this->assertSame($post, $result);
    }
}
