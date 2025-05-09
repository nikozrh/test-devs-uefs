<?php

namespace Database\Seeders;

use App\Domain\Tag\Entities\Tag;

use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Nodejs', 'typeScript', 'JavaScript', 'Java', 'C#',
            'Backend', 'MongoDb', 'Database', 'api', 'UnitTests'
];

        foreach ($tags as $tagName) {
            Tag::firstOrCreate(['name' => $tagName]);
        }

        // Opcional: Criação de tags adicionais usando a fábrica
        Tag::factory(5)->create();
    }
}
