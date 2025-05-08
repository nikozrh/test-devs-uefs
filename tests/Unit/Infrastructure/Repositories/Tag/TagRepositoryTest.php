<?php

namespace Tests\Unit\Repositories;

use App\Domain\Tag\Entities\Tag;
use App\Domain\Tag\Repositories\TagReadRepositoryInterface;
use App\Domain\Tag\Repositories\TagWriteRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Collection;

#[Group('TagInfrastructure')]
#[Group('TagRepository')]
class TagRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private TagReadRepositoryInterface $tagReadRepository;
    private TagWriteRepositoryInterface $tagWriteRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tagReadRepository = $this->app->make(TagReadRepositoryInterface::class);
        $this->tagWriteRepository = $this->app->make(TagWriteRepositoryInterface::class);
    }

    #[Test]
    public function it_can_return_all_tags(): void
    {
        Tag::factory(3)->create();

        $result = $this->tagReadRepository->getAll();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(3, $result);
        $this->assertInstanceOf(Tag::class, $result->first());
      
    }

    #[Test]
    public function it_can_find_a_tag_by_id(): void
    {
        $tag = Tag::factory()->create();

        $found = $this->tagReadRepository->findById($tag->id);

        $this->assertNotNull($found);
        $this->assertInstanceOf(Tag::class, $found);
        $this->assertEquals($tag->id, $found->id);
    }

    #[Test]
    public function it_can_find_a_tag_by_name(): void
    {
        $tag = Tag::factory()->create(['name' => 'Specific Tag Name']);

        $found = $this->tagReadRepository->findByName('Specific Tag Name');

        $this->assertNotNull($found);
        $this->assertInstanceOf(Tag::class, $found);
        $this->assertEquals($tag->id, $found->id);
        $this->assertEquals('Specific Tag Name', $found->name);
    }

    #[Test]
    public function it_returns_null_when_tag_not_found_by_id(): void
    {
        $found = $this->tagReadRepository->findById(999);
        $this->assertNull($found);
    }

    #[Test]
    public function it_returns_null_when_tag_not_found_by_name(): void
    {
        $found = $this->tagReadRepository->findByName('NonExistent TagName');
        $this->assertNull($found);
    }

    #[Test]
    public function it_can_create_a_tag(): void
    {
        $data = ['name' => 'Test Tag'];

        $tag = $this->tagWriteRepository->create($data);

        $this->assertDatabaseHas('tags', ['name' => 'Test Tag']);
        $this->assertInstanceOf(Tag::class, $tag);
        $this->assertNotNull($tag->id);
        $this->assertEquals('Test Tag', $tag->name);
    }

    #[Test]
    public function it_can_update_a_tag(): void
    {
        $tag = Tag::factory()->create(['name' => 'Old Name']);
        $data = ['name' => 'New Name'];

        $updated = $this->tagWriteRepository->update($tag->id, $data);

        $this->assertEquals('New Name', $updated->name);
        $this->assertDatabaseHas('tags', ['id' => $tag->id, 'name' => 'New Name']);
    }

    #[Test]
    public function it_can_delete_a_tag(): void
    {
        $tag = Tag::factory()->create();

        $result = $this->tagWriteRepository->delete($tag->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
    }
}
