<?php

namespace Tests\Feature;

use App\Domain\User\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        User::truncate();
    }

    #[Test]
    public function it_can_list_all_users()
    {
        User::factory(3)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data') 
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'email']
                ],
            ]);
    }

    #[Test]
    public function it_can_create_a_user()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123', // Add if validation requires confirmation
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201) // HTTP 201 Created
            ->assertJsonFragment([ // Verify fragment to avoid relying on exact structure
                'name' => 'Test User',
                'email' => 'test@example.com'
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com'
        ]);
    }

    #[Test]
    public function it_shows_a_specific_user()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [ 
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email
                ]
            ]);
    }

    #[Test]
    public function it_returns_404_when_user_not_found()
    {
        $response = $this->getJson('/api/users/99999'); 
        $response->assertStatus(404);
    }

    #[Test]
    public function it_can_update_a_user()
    {
        $user = User::factory()->create();
        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];

        $response = $this->putJson("/api/users/{$user->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'Updated Name',
                'email' => 'updated@example.com'
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com'
        ]);
    }

    #[Test]
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(204); 

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    #[Test]
    public function it_validates_user_creation_required_fields()
    {
        $response = $this->postJson('/api/users', []);
        $response->assertStatus(422) 
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    #[Test]
    public function it_validates_user_creation_email_unique()
    {
        User::factory()->create(['email' => 'unique@example.com']);
        $userData = [
            'name' => 'Another User',
            'email' => 'unique@example.com', // Email already exists
            'password' => 'password123',
        ];
        $response = $this->postJson('/api/users', $userData);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    #[Test]
    public function it_validates_user_update_email_unique_for_other_users()
    {
        $user1 = User::factory()->create(['email' => 'user1@example.com']);
        $user2 = User::factory()->create(['email' => 'user2@example.com']);

        $updatedData = [
            'name' => 'User 2 Updated',
            'email' => 'user1@example.com', // Trying to use user1's email
        ];

        $response = $this->putJson("/api/users/{$user2->id}", $updatedData);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    #[Test]
    public function it_allows_user_to_update_with_their_own_email()
    {
        $user = User::factory()->create(['email' => 'self@example.com']);
        $updatedData = [
            'name' => 'Self Updated',
            'email' => 'self@example.com', // Same email
        ];

        $response = $this->putJson("/api/users/{$user->id}", $updatedData);
        $response->assertStatus(200)
             ->assertJsonFragment(['email' => 'self@example.com']);
    }
}
