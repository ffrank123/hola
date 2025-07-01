<?php

namespace Database\Factories;

use App\Models\PersonalEvent;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalEventFactory extends Factory
{
    protected $model = PersonalEvent::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'start_date' => $this->faker->dateTimeBetween('+1 days', '+1 month'),
            'end_date' => $this->faker->dateTimeBetween('+1 days', '+2 months'),
        ];
    }
} 