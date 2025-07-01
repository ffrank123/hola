<?php

namespace Database\Factories;

use App\Models\PortalDesign;
use App\Models\Portal;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortalDesignFactory extends Factory
{
    protected $model = PortalDesign::class;

    public function definition()
    {
        return [
            'portal_id' => Portal::factory(),
            'theme' => $this->faker->word(),
            'settings' => json_encode(['color' => $this->faker->safeColorName()]),
        ];
    }
} 