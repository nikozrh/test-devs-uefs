<?php

namespace Tests\Feature;

use App\Domain\Post\Entities\Post;
use App\Domain\Tag\Entities\Tag;
use App\Domain\User\Entities\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Clear all related tables before each test
        Post::truncate();
        User::truncate();
        Tag::truncate();
        DB::table('post_tag')->truncate();

        $this->user = User::factory()->create();
    }



    #[Test]
    public function it_can_create_a_post()
    {
        $data = [
            'title' => 'Test Post',
            'content' => 'This is a test post content',
            'user_id' => $this->user->id,
            'tags' => Tag::factory(3)->create()->pluck('id')->toArray(),
        ];

        $response = $this->postJson('/api/posts', $data);

        $response->assertStatus(201)
            ->assertJson([
                'title' => 'Test Post',
                'content' => 'This is a test post content',
                'user_id' => $this->user->id
            ]);
    }

    #[Test]
    public function it_shows_a_specific_post()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $newTags = Tag::factory(2)->create()->pluck('id')->toArray();
        $post->tags()->attach($newTags);

        $response = $this->getJson("/api/posts/{$post->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $post->id,
                'title' => $post->title,
                'user_id' => $this->user->id, // Includes user_id for direct comparison
            ])
            ->assertJsonCount(2, 'tags');
    }

    #[Test]
    public function it_returns_404_when_post_not_found()
    {
        $response = $this->getJson('/api/posts/999');
        $response->assertStatus(404);
    }

    #[Test]
    public function it_can_update_a_post()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $newTags = Tag::factory(2)->create()->pluck('id')->toArray();

        $data = [
            'title' => 'Updated Title',
            'content' => 'Updated content',
            'user_id' => $this->user->id, // Adding required user_id
            'tags' => $newTags
        ];

        $response = $this->putJson("/api/posts/{$post->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'title' => 'Updated Title',
                'content' => 'Updated content'
            ]);
    }

    #[Test]
    public function it_can_delete_a_post()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);

        $response = $this->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Post deleted successfully']);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
