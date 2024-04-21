<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Julius Derla',
            'email' => 'juliusderla@example.com',
            'account_type' => 'Writer',
            'provider' => 'Jderl',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Jholo Sabana',
            'email' => 'jholosabana@example.com',
            'account_type' => 'Writer',
            'provider' => 'Jderl',
        ]);


        \App\Models\Category::create([
            'name' => 'Test Category'
        ]);

        \App\Models\Post::create([
            'title' => 'Test Post',
            'slug' => 'Test Slug',
            'description' => 'Test Description',
            'image' => null,
            'status' => true,
            'writer_id' => 1,
            'category_id' => 1,
        ]);

        \App\Models\Post::create([
            'title' => 'Test Post II',
            'slug' => 'Test Slug II',
            'description' => 'Test Description II',
            'image' => null,
            'status' => true,
            'writer_id' => 2,
            'category_id' => 1,
        ]);
    }
}
