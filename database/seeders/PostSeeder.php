<?php

namespace Database\Seeders;

use App\Domain\Post\Entities\Post;
use App\Domain\User\Entities\User;
use App\Domain\Tag\Entities\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users to associate posts with
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('No users found, creating one default user for posts.');
            // Ensure the factory creates a user that can be retrieved by User::all() immediately or handle it.
            User::factory(1)->create([
                'email' => 'author@example.com'
            ]);
            $users = User::all(); // Re-fetch users
        }

        // Get all tags or create some if none exist
        $tags = Tag::all();
        if ($tags->count() < 3) {
            Tag::factory(3 - $tags->count())->create();
            $tags = Tag::all(); // Re-fetch tags
        }

        // Ensure there are tags to select from before proceeding
        if ($tags->isEmpty()) {
            $this->command->info('PostSeeder: No tags available to attach to posts. Skipping tag attachment.');
            // Optionally create some default tags here if this state is problematic
        }

        $users->each(function ($user) use ($tags) {
            Post::factory(5)->create([
                'user_id' => $user->id
            ])->each(function ($post) use ($tags) {
                if ($tags->isEmpty()) {
                    return; // No tags to attach
                }

                // Determine the number of tags to attach (1 to 3, but not more than available)
                $numberOfTagsToAttach = rand(1, min(3, $tags->count()));

                // Get random tag models. random($count) always returns a Collection.
                $randomTagModels = $tags->random($numberOfTagsToAttach);

                // Pluck IDs, ensure uniqueness, and convert to array.
                $tagIds = $randomTagModels->pluck('id')->unique()->toArray();

                if (!empty($tagIds)) {
                    // Use syncWithoutDetaching to prevent errors if a relationship already exists.
                    $post->tags()->syncWithoutDetaching($tagIds);
                }
            });
        });

        $this->command->info('PostSeeder: Finished creating posts with tags.');
    }
}
