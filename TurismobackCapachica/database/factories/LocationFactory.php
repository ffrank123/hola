<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition()
    {
        return [
            'name' => $this->faker->city(),
            'type' => 'comunidad',
            'descripcion_corta' => $this->faker->sentence(),
            'descripcion_larga' => $this->faker->paragraph(),
            'atractivos' => $this->faker->sentence(),
            'habitantes' => $this->faker->numberBetween(100, 10000),
            'estado' => 'activa',
            'imagen' => null,
            'galeria' => json_encode([]),
        ];
    }
} 