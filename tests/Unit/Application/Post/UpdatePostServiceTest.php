<?php

namespace Tests\Unit\Application\Post;

use App\Application\Services\Post\UpdatePostService;
use App\Domain\Post\Entities\Post;
use App\Domain\Post\Repositories\PostWriteRepositoryInterface;
use App\Domain\Post\Repositories\PostReadRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class UpdatePostServiceTest extends TestCase
{
    private MockObject $writeRepo;
    private MockObject $readRepo;
    private UpdatePostService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->writeRepo = $this->createMock(PostWriteRepositoryInterface::class);
        $this->readRepo = $this->createMock(PostReadRepositoryInterface::class);
        $this->service = new UpdatePostService($this->writeRepo, $this->readRepo);
    }

    public function test_execute_returns_null_if_not_found(): void
    {
        $this->writeRepo->method('update')->willReturn(null);
        $result = $this->service->execute(123, ['title' => 'foo']);
        $this->assertNull($result);
    }

    public function test_execute_updates_and_returns_post(): void
    {
        $data = ['title' => 'Updated', 'content' => 'New content', 'tags' => [3,4]];
        $post = new Post(['id' => 1, 'title' => 'Updated', 'content' => 'New content', 'user_id' => 1]);

        DB::shouldReceive('transaction')->once()->andReturnUsing(function ($callback) use ($post, $data) {
            $this->writeRepo->expects($this->once())
                ->method('update')
                ->with(1, $data)
                ->willReturn($post);

            $this->writeRepo->expects($this->once())
                ->method('syncTags')
                ->with($post, $data['tags']);

            $this->readRepo->expects($this->once())
                ->method('findById')
                ->with(1)
                ->willReturn($post);

            return $callback();
        });

        $result = $this->service->execute(1, $data);
        $this->assertSame($post, $result);
    }
}
