<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\Company;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition()
    {
        return [
            'company_id' => Company::factory(),
            'category_id' => Category::factory(),
            'location_id' => Location::factory(),
            'title' => $this->faker->sentence(3),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->paragraph(),
            'ubicacion_detallada' => $this->faker->address(),
            'price' => $this->faker->randomFloat(2, 50, 1000),
            'policy_cancellation' => $this->faker->sentence(),
            'capacity' => $this->faker->numberBetween(1, 20),
            'duration' => $this->faker->word(),
            'status' => 'active',
            'published_at' => now(),
            'is_active' => true,
        ];
    }
} 