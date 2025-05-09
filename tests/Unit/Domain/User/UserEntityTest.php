<?php

namespace Tests\Unit\Domain\User;

use App\Domain\User\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group('UserDomain')]
#[Group('UserEntity')]
#[CoversClass(User::class)]
class UserEntityTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_instantiates_with_given_attributes(): void
    {
        $name     = $this->faker->name;
        $email    = $this->faker->unique()->safeEmail;
        $password = 'password123';

        $user = new User([
            'name'     => $name,
            'email'    => $email,
            'password' => $password,
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($name, $user->name);
        $this->assertEquals($email, $user->email);
    }

    public function test_posts_relation_method_exists(): void
    {
        $user = User::factory()->create();
        $this->assertTrue(
            method_exists($user, 'posts'),
            'User entity must define a posts relationship method.'
        );
    }

    public function test_fillable_array_matches_expected(): void
    {
        $user     = new User();
        $expected = ['name', 'email', 'password'];
        $this->assertEquals($expected, $user->getFillable());
    }

    public function test_hidden_array_matches_expected(): void
    {
        $user     = new User();
        $expected = ['password', 'remember_token'];
        $this->assertEquals($expected, $user->getHidden());
    }

    public function test_casts_array_matches_expected(): void
    {
        $user     = new User();
        $expected = [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'id'                => 'int',
        ];
        $this->assertEquals($expected, $user->getCasts());
    }
}