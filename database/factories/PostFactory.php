<?php

namespace Database\Factories;

use App\Domain\Post\Entities\Post as DomainPost;
use App\Domain\User\Entities\User as DomainUser;
use App\Domain\Tag\Entities\Tag as DomainTag; 
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<DomainPost>
 */
class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DomainPost::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'user_id' => DomainUser::factory(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (DomainPost $post) {
            $tags = DomainTag::inRandomOrder() // Updated
                ->limit($this->faker->numberBetween(2, 5))
                ->pluck('id');

            $post->tags()->attach($tags);
        });
    }
}
