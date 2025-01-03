<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Mockery;
use App\Services\TagService;
use App\Repositories\Interfaces\TagRepositoryInterface;

class TagServiceTest extends TestCase
{
    protected $tagService;
    protected $tagRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock do TagRepositoryInterface
        $this->tagRepositoryMock = Mockery::mock(TagRepositoryInterface::class);
        $this->tagService = new TagService($this->tagRepositoryMock);
    }

    public function testGetAllTags()
    {
        $tags = [
            ['id' => 1, 'name' => 'Laravel'],
            ['id' => 2, 'name' => 'CakePHP']
        ];

        $this->tagRepositoryMock
            ->shouldReceive('getAllTags')
            ->once()
            ->andReturn($tags);

        $result = $this->tagService->getAllTags();
        $this->assertEquals($tags, $result);
    }

    public function testCreateTag()
    {
        $tagData = ['name' => 'Laravel'];
        $createdTag = ['id' => 1, 'name' => 'CakePHP'];

        $this->tagRepositoryMock
            ->shouldReceive('createTag')
            ->once()
            ->with($tagData)
            ->andReturn($createdTag);

        $result = $this->tagService->createTag($tagData);
        $this->assertEquals($createdTag, $result);
    }

    public function testDeleteTag()
    {
        $tagId = 1;

        $this->tagRepositoryMock
            ->shouldReceive('deleteTag')
            ->once()
            ->with($tagId)
            ->andReturn(true);

        $result = $this->tagService->deleteTag($tagId);
        $this->assertTrue($result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
