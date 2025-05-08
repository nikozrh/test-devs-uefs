<?php

namespace Tests\Unit\Repositories;

use App\Domain\Post\Entities\Post;
use App\Domain\Post\Repositories\PostReadRepositoryInterface;
use App\Domain\Post\Repositories\PostWriteRepositoryInterface;
use App\Domain\User\Entities\User;
use App\Domain\Tag\Entities\Tag; // Updated
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test; // If using PHPUnit 9+ attributes
use Illuminate\Support\Collection;

#[Group('PostInfrastructure')]
#[Group('PostRepository')]
class PostRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private PostReadRepositoryInterface $postReadRepository;
    private PostWriteRepositoryInterface $postWriteRepository;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->postReadRepository = $this->app->make(PostReadRepositoryInterface::class);
        $this->postWriteRepository = $this->app->make(PostWriteRepositoryInterface::class);
        $this->user = User::factory()->create();
    }

    #[Test]
    public function it_can_return_all_posts(): void
    {
        Post::factory(3)->create(['user_id' => $this->user->id]);

        $result = $this->postReadRepository->getAll();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(3, $result); // Adjusted count to reflect only created posts
        $this->assertInstanceOf(Post::class, $result->first());
        $this->assertNotNull($result->first()->user);
    }

    #[Test]
    public function it_can_find_a_post(): void
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $testTags = Tag::factory(2)->create()->pluck('id')->toArray(); // Tag factory now uses the correct entity
        $this->postWriteRepository->syncTags($post, $testTags); // Use repository to sync tags

        $found = $this->postReadRepository->findById($post->id);

        $this->assertNotNull($found);
        $this->assertInstanceOf(Post::class, $found);
        $this->assertEquals($post->id, $found->id);
        $this->assertCount(2, $found->tags);
    }

    #[Test]
    public function it_returns_null_when_post_not_found(): void
    {
        $found = $this->postReadRepository->findById(999);
        $this->assertNull($found);
    }

    #[Test]
    public function it_can_create_a_post(): void
    {
        $data = [
            'title' => 'Test Post',
            'content' => 'Test content',
            'user_id' => $this->user->id
        ];

        $post = $this->postWriteRepository->create($data); // Changed: Use create with array data

        $this->assertDatabaseHas('posts', ['title' => 'Test Post']);
        $this->assertInstanceOf(Post::class, $post);
        $this->assertNotNull($post->id); // Ensure ID is set after save
    }

    #[Test]
    public function it_can_update_a_post(): void
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $data = ['title' => 'Updated Title'];

        $updated = $this->postWriteRepository->update($post->id, $data); // Changed: Pass ID instead of entity

        $this->assertEquals('Updated Title', $updated->title);
        $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => 'Updated Title']);
    }

    #[Test]
    public function it_can_delete_a_post(): void
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);

        $result = $this->postWriteRepository->delete($post->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    #[Test]
    public function it_can_sync_tags(): void
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $newTags = Tag::factory(2)->create()->pluck('id')->toArray(); // Tag factory now uses the correct entity

        $this->postWriteRepository->syncTags($post, $newTags);

        $this->assertCount(2, $post->fresh()->tags);
    }
}
