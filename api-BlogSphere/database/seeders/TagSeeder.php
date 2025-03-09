<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'Inspirador'],
            ['name' => 'Reflexivo'],
            ['name' => 'Educativo'],
            ['name' => 'Humorístico'],
        ];

        DB::table('tags')->insert($tags);
    }
}
