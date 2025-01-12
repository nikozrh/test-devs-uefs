<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!User::where('email', 'admin@api.com.br')->first()){
            User::create([
                'name' => 'Admin',
                'email' => 'admin@api.com.br',
                'password' => Hash::make('123456', ['rounds' => 12]),
            ]); 
        }
        if(!User::where('email', 'angelo@api.com.br')->first()){
            User::create([
                'name' => 'Angelo',
                'email' => 'angelo@api.com.br',
                'password' => Hash::make('123456', ['rounds' => 12]),
            ]); 
        }
        if(!User::where('email', 'jose@api.com.br')->first()){
            User::create([
                'name' => 'José',
                'email' => 'jose@api.com.br',
                'password' => Hash::make('123456', ['rounds' => 12]),
            ]); 
        }
    }
}
