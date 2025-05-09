<?php

namespace Database\Factories;

use App\Domain\Tag\Entities\Tag as DomainTag; 
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<DomainTag>
 */
class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DomainTag::class; // Explicitly set to new Tag entity

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
        ];
    }
}
