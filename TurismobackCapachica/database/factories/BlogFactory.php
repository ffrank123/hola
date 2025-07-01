<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition()
    {
        return [
            'company_id' => Company::factory(),
            'title' => $this->faker->sentence(3),
            'content' => $this->faker->paragraph(),
            'featured_image_url' => null,
            'status' => 'published',
            'published_at' => now(),
        ];
    }
} 