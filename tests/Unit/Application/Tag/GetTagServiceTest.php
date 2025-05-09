<?php

namespace Tests\Unit\Application\Tag;

use App\Application\Services\Tag\GetTagService;
use App\Domain\Tag\Entities\Tag;
use App\Domain\Tag\Repositories\TagReadRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class GetTagServiceTest extends TestCase
{
    private MockObject $readRepo;
    private GetTagService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->readRepo = $this->createMock(TagReadRepositoryInterface::class);
        $this->service = new GetTagService($this->readRepo);
    }

    public function test_findById_returns_tag_if_exists(): void
    {
        $tag = new Tag(['id' => 1, 'name' => 'test']);
        $this->readRepo->method('findById')->with(1)->willReturn($tag);

        $result = $this->service->findById(1);
        $this->assertSame($tag, $result);
    }

    public function test_findById_returns_null_if_not_exists(): void
    {
        $this->readRepo->method('findById')->with(999)->willReturn(null);
        $this->assertNull($this->service->findById(999));
    }

    public function test_getAll_returns_collection_of_tags(): void
    {
        $tags = new Collection([
            new Tag(['id' => 1, 'name' => 'a']),
            new Tag(['id' => 2, 'name' => 'b']),
        ]);
        $this->readRepo->method('getAll')->willReturn($tags);

        $result = $this->service->getAll();
        $this->assertSame($tags, $result);
    }
}
