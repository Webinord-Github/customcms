<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::truncate();

        $post = Post::create([
            'title' => 'Post 1',
            'user_id' => 1,
            'slug' => 'post-1',
            'excerpt' => 'My first post.',
            'image' => 'x.png',
            'status' => 'published',
            'body' => 'My first post.'
        ]);
        $post->categories()->sync([1,3]);

        $post = Post::create([
            'title' => 'Post 2',
            'user_id' => 1,
            'slug' => 'post-2',
            'excerpt' => 'My first post.',
            'image' => 'x.png',
            'status' => 'draft',
            'body' => 'My first post.'
        ]);
        $post->categories()->sync([1,4]);

        $post = Post::create([
            'title' => 'Post 3',
            'user_id' => 2,
            'slug' => 'post-3',
            'excerpt' => 'My first post.',
            'image' => 'x.png',
            'status' => 'draft',
            'body' => 'My first post.'
        ]);
        $post->categories()->sync([2,3]);

        $post = Post::create([
            'title' => 'Post 4',
            'user_id' => 2,
            'slug' => 'post-4',
            'excerpt' => 'My first post.',
            'image' => 'x.png',
            'status' => 'archived',
            'body' => 'My first post.'
        ]);
        $post->categories()->sync([2,4]);
    }
}
