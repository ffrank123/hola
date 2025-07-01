<?php

namespace Database\Factories;

use App\Models\ServiceMedia;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceMediaFactory extends Factory
{
    protected $model = ServiceMedia::class;

    public function definition()
    {
        return [
            'service_id' => Service::factory(),
            'url' => $this->faker->imageUrl(),
            'type' => 'image',
        ];
    }
} 