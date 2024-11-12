<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Tag;
use App\Models\PostTag;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        // Criar 10 usuários fictícios
        $users = User::factory(10)->create();

        // Criar 10 tags fictícias
        $tags = Tag::factory(10)->create();

        // Criar 10 posts fictícios
        $posts = Post::factory(10)->create();

        // Associar tags aos posts na tabela intermediária post_tag
        foreach ($posts as $post) {
            // Pega um número aleatório de tags para associar ao post
            $post->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}