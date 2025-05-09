<?php

namespace Tests\Unit\Application\Tag;

use App\Application\Services\Tag\CreateTagService;
use App\Domain\Tag\Entities\Tag;
use App\Domain\Tag\Repositories\TagWriteRepositoryInterface;
use Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class CreateTagServiceTest extends TestCase
{
    private MockObject $writeRepo;
    private CreateTagService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->writeRepo = $this->createMock(TagWriteRepositoryInterface::class);
        $this->service = new CreateTagService($this->writeRepo);
    }

    public function test_execute_creates_and_returns_tag(): void
    {
        $data = ['name' => 'test-tag'];
        $tag = new Tag(['id' => 1, 'name' => 'test-tag']);

        $this->writeRepo->expects($this->once())
            ->method('create')
            ->with($data)
            ->willReturn($tag);

        $result = $this->service->execute($data);
        $this->assertSame($tag, $result);
    }
}