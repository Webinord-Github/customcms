<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::find(1);

        Post::truncate();

        $admin->pages()->saveMany([
            new Post([
                'title' => 'Post 1',
                'slug' => 'post-1',
                'excerpt' => 'Post 1 Excerpt',
                'status' => 'Published',
                'body' => 'My first post.'
            ]),
            new Post([
                'title' => 'Post 2',
                'slug' => 'post-2',
                'excerpt' => 'Post 2 Excerpt',
                'status' => 'Archived',
                'body' => 'My second post.'
            ]),
            new Post([
                'title' => 'Post 3',
                'slug' => 'post-3',
                'excerpt' => 'Post 3 Excerpt',
                'status' => 'Draft',
                'body' => 'Another post.'
            ]),
        ]);
    }
}
