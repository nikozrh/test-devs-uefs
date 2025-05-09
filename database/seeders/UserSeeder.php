<?php

namespace Database\Seeders;

use App\Domain\User\Entities\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Import Hash facade

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'admin@example.com'], // Attributes to find the user by
            [
                'name' => 'Admin',
                'password' => Hash::make('password'), // Use Hash::make for password hashing
                'email_verified_at' => now(), // Optionally mark email as verified
            ]
        );
    }
}
