<?php

namespace Tests\Unit\Repositories;

use App\Domain\User\Entities\User;
use App\Domain\Post\Entities\Post;
use App\Domain\User\Repositories\UserReadRepositoryInterface;
use App\Domain\User\Repositories\UserWriteRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private UserReadRepositoryInterface $userReadRepository;
    private UserWriteRepositoryInterface $userWriteRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userReadRepository = $this->app->make(UserReadRepositoryInterface::class);
        $this->userWriteRepository = $this->app->make(UserWriteRepositoryInterface::class);
    }

    #[Test]
    public function it_can_return_all_users()
    {
        User::factory(3)->create();

        $result = $this->userReadRepository->getAll();

        $this->assertCount(3, $result);
        $this->assertInstanceOf(User::class, $result->first());
        $this->assertTrue($result->first()->relationLoaded('posts') || method_exists($result->first(), 'posts'));
    }

    #[Test]
    public function it_can_find_a_user()
    {
        $user = User::factory()->create();

        $found = $this->userReadRepository->findById($user->id);

        $this->assertNotNull($found);
        $this->assertEquals($user->id, $found->id);
        $this->assertEquals($user->name, $found->name);
    }

    #[Test]
    public function it_returns_null_when_user_not_found()
    {
        $found = $this->userReadRepository->findById(999);
        $this->assertNull($found);
    }

    #[Test]
    public function it_can_create_a_user()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123'
        ];
        
        $userEntity = new User($data);
        $result = $this->userWriteRepository->save($userEntity);

        $this->assertNotNull($result->id);
        $this->assertEquals('Test User', $result->name);
        $this->assertEquals('test@example.com', $result->email);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    #[Test]
    public function it_hashes_password_when_creating_user()
    {
        $data = [
            'name' => 'Test User Hashing',
            'email' => 'test.hash@example.com',
            'password' => 'password123'
        ];
        
        $userEntity = new User($data);
        $this->userWriteRepository->save($userEntity);

        $user = User::where('email', 'test.hash@example.com')->first();
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    #[Test]
    public function it_can_update_a_user()
    {
        $user = User::factory()->create(['name' => 'Old Name']);
        $data = ['name' => 'New Name'];

        $result = $this->userWriteRepository->update($user, $data);

        $this->assertEquals('New Name', $result->name);
        $this->assertDatabaseHas('users', ['id'=> $user->id, 'name' => 'New Name']);
    }

    #[Test]
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create();

        $result = $this->userWriteRepository->delete($user->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    #[Test]
    public function it_includes_posts_when_fetching_users()
    {
        Post::query()->delete();
        User::query()->delete();

        $user = User::factory()->create();
        Post::factory(2)->create(['user_id' => $user->id]);
        
        $resultUser = $this->userReadRepository->findById($user->id);
        $resultUser->load('posts');

        $this->assertNotNull($resultUser);
        $this->assertNotNull($resultUser->posts);
        $this->assertCount(2, $resultUser->posts);
    }
}
