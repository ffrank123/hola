<?php

namespace Database\Factories;

use App\Models\Page;
use App\Models\Portal;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition()
    {
        return [
            'portal_id' => Portal::factory(),
            'title' => $this->faker->sentence(3),
            'content' => $this->faker->paragraph(),
            'status' => 'published',
        ];
    }
} 