<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Eloquent\TagRepository;
use App\Models\Tag;

class TagRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $tagRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tagRepository = new TagRepository();
    }

    public function testGetAllTags()
    {
        Tag::factory()->count(3)->create();
        $tags = $this->tagRepository->getAllTags();

        $this->assertCount(3, $tags);
    }

    public function testGetTagById()
    {
        $tag = Tag::factory()->create();
        $retrievedTag = $this->tagRepository->getTagById($tag->id);

        $this->assertEquals($tag->id, $retrievedTag->id);
    }

    public function testCreateTag()
    {
        $tagData = ['name' => 'PHP'];
        $tag = $this->tagRepository->createTag($tagData);

        $this->assertDatabaseHas('tags', ['name' => 'PHP']);
        $this->assertEquals($tagData['name'], $tag->name);
    }

    public function testUpdateTag()
    {
        $tag = Tag::factory()->create(['name' => 'Old Tag']);
        $updatedData = ['name' => 'New Tag'];

        $updatedTag = $this->tagRepository->updateTag($tag->id, $updatedData);

        $this->assertEquals('New Tag', $updatedTag->name);
    }

    public function testDeleteTag()
    {
        $tag = Tag::factory()->create();
        $result = $this->tagRepository->deleteTag($tag->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
    }
}
