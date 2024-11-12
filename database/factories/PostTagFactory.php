<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostTagFactory extends Factory
{
    protected $model = PostTag::class;

    public function definition()
    {
        return [
            'post_id' => $this->faker->randomElement(Post::pluck('id')->toArray()),
            'tag_id' => $this->faker->randomElement(Tag::pluck('id')->toArray()),
        ];
    }
}