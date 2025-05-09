<?php

namespace Tests\Unit\Application\Tag;

use App\Application\Services\Tag\UpdateTagService;
use App\Domain\Tag\Entities\Tag;
use App\Domain\Tag\Repositories\TagWriteRepositoryInterface;
use Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class UpdateTagServiceTest extends TestCase
{
    private MockObject $writeRepo;
    private UpdateTagService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->writeRepo = $this->createMock(TagWriteRepositoryInterface::class);
        $this->service = new UpdateTagService($this->writeRepo);
    }

    public function test_execute_returns_null_if_not_found(): void
    {
        $this->writeRepo->method('update')->willReturn(null);
        $this->assertNull($this->service->execute(123, ['name' => '']));
    }

    public function test_execute_updates_and_returns_tag(): void
    {
        $data = ['name' => 'updated-tag'];
        $tag = new Tag(['id' => 1, 'name' => 'updated-tag']);

        $this->writeRepo->expects($this->once())
            ->method('update')
            ->with(1, $data)
            ->willReturn($tag);

        $result = $this->service->execute(1, $data);
        $this->assertSame($tag, $result);
    }
}