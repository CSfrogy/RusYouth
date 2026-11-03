<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admintest@mail.com',
            'password' => bcrypt('password'),
        ]);

        $users = User::factory(10)->create();

        $posts = Post::factory(50)
            ->has(

                Comment::factory(3)
                    ->state(fn (array $attributes) => [
                        'user_id' => $users->random()->id,
                    ]),
            )->create(['user_id' => $admin->id]);

        $comments = Comment::all();
        foreach ($comments->random(10) as $comment) {
            Comment::factory()->reply($comment)->create(['user_id' => $users->random()->id]);
        }

        $publishedPosts = Post::published()->pluck('id');
        foreach ($users as $user) {
            $user->likedPosts()->syncWithoutDetaching($publishedPosts->shuffle()->take(rand(3, 15)));
        }
    }
}
