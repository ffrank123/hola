<?php

namespace Database\Factories;

use App\Models\Portal;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortalFactory extends Factory
{
    protected $model = Portal::class;

    public function definition()
    {
        return [
            'name' => $this->faker->domainName(),
            'description' => $this->faker->sentence(),
            'status' => 'active',
        ];
    }
} 