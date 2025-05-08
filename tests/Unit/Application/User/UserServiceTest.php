<?php

namespace Tests\Unit\Application\User;

use App\Application\Services\User\CreateUserService;
use App\Application\Services\User\DeleteUserService;
use App\Application\Services\User\GetUserService;
use App\Application\Services\User\UpdateUserService;
use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserReadRepositoryInterface;
use App\Domain\User\Repositories\UserWriteRepositoryInterface;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group('UserApplication')]
#[Group('UserService')]
#[CoversClass(CreateUserService::class)]
#[CoversClass(DeleteUserService::class)]
#[CoversClass(GetUserService::class)]
#[CoversClass(UpdateUserService::class)]
class UserServiceTest extends TestCase
{
    use WithFaker;

    private UserReadRepositoryInterface|MockInterface $mockReadRepository;
    private UserWriteRepositoryInterface|MockInterface $mockWriteRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockReadRepository = Mockery::mock(UserReadRepositoryInterface::class);
        $this->mockWriteRepository = Mockery::mock(UserWriteRepositoryInterface::class);
    }

    // Describe: CreateUserService
    public function test_create_user_service_should_save_and_return_user(): void
    {
        $service = new CreateUserService($this->mockWriteRepository);
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
        ];

        $this->mockWriteRepository
            ->shouldReceive('save')
            ->once()
            ->withArgs(function (User $user) use ($userData) {
                return $user->name === $userData['name'] && $user->email === $userData['email'];
            })
            ->andReturnUsing(function (User $user) {
                $user->id = 1; // Simulate saving and getting an ID
                $user->created_at = now();
                $user->updated_at = now();
                return $user;
            });

        $result = $service->execute($userData);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($userData['name'], $result->name);
        $this->assertEquals($userData['email'], $result->email);
        $this->assertNotNull($result->id);
    }

    // Describe: GetUserService
    public function test_get_user_service_should_return_user_by_id(): void
    {
        $service = new GetUserService($this->mockReadRepository);
        $user = User::factory()->make(['id' => 1]);

        $this->mockReadRepository
            ->shouldReceive('findById')
            ->once()
            ->with('1')
            ->andReturn($user);

        $result = $service->findById('1');
        $this->assertEquals($user, $result);
    }

    public function test_get_user_service_should_return_all_users(): void
    {
        $service = new GetUserService($this->mockReadRepository);
        $users = User::factory()->count(2)->make();

        $this->mockReadRepository
            ->shouldReceive('getAll')
            ->once()
            ->with([])
            ->andReturn(new Collection($users));

        $result = $service->getAll();
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
    }

    // Describe: UpdateUserService
    public function test_update_user_service_should_update_and_return_user(): void
    {
        $service = new UpdateUserService($this->mockWriteRepository, $this->mockReadRepository);
        $existingUser = User::factory()->make(['id' => 1, 'name' => 'Old Name']);
        $updateData = ['name' => 'New Name'];

        $this->mockReadRepository
            ->shouldReceive('findById')
            ->once()
            ->with('1')
            ->andReturn($existingUser);

        $this->mockWriteRepository
            ->shouldReceive('update')
            ->once()
            ->withArgs(function (User $user, array $data) use ($existingUser, $updateData) {
                return $user->id === $existingUser->id && $data['name'] === $updateData['name'];
            })
            ->andReturnUsing(function (User $user, array $data) {
                $user->fill($data);
                return $user;
            });

        $result = $service->execute('1', $updateData);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($updateData['name'], $result->name);
    }

    public function test_update_user_service_should_return_null_if_user_not_found(): void
    {
        $service = new UpdateUserService($this->mockWriteRepository, $this->mockReadRepository);
        $this->mockReadRepository->shouldReceive('findById')->once()->with('nonexistent')->andReturnNull();

        $result = $service->execute('nonexistent', ['name' => 'test']);
        $this->assertNull($result);
    }

    // Describe: DeleteUserService
    public function test_delete_user_service_should_return_true_on_success(): void
    {
        $service = new DeleteUserService($this->mockWriteRepository, $this->mockReadRepository);
        $existingUser = User::factory()->make(['id' => 1]);

        $this->mockReadRepository
            ->shouldReceive('findById')
            ->once()
            ->with('1')
            ->andReturn($existingUser);

        $this->mockWriteRepository
            ->shouldReceive('delete')
            ->once()
            ->with('1')
            ->andReturn(true);

        $result = $service->execute('1');
        $this->assertTrue($result);
    }

    public function test_delete_user_service_should_return_false_if_user_not_found(): void
    {
        $service = new DeleteUserService($this->mockWriteRepository, $this->mockReadRepository);
        $this->mockReadRepository->shouldReceive('findById')->once()->with('nonexistent')->andReturnNull();

        $result = $service->execute('nonexistent');
        $this->assertFalse($result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
