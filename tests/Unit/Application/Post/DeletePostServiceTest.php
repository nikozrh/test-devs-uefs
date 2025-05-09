<?php

namespace Tests\Unit\Application\Post;

use App\Application\Services\Post\DeletePostService;
use App\Domain\Post\Repositories\PostWriteRepositoryInterface;
use Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class DeletePostServiceTest extends TestCase
{
    private MockObject $writeRepo;
    private DeletePostService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->writeRepo = $this->createMock(PostWriteRepositoryInterface::class);
        $this->service = new DeletePostService($this->writeRepo);
    }

    public function test_execute_returns_true_on_success(): void
    {
        $this->writeRepo->expects($this->once())
            ->method('delete')
            ->with(1)
            ->willReturn(true);

        $this->assertTrue($this->service->execute(1));
    }

    public function test_execute_returns_false_on_failure(): void
    {
        $this->writeRepo->expects($this->once())
            ->method('delete')
            ->with(2)
            ->willReturn(false);

        $this->assertFalse($this->service->execute(2));
    }
}