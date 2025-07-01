<?php

namespace Database\Factories;

use App\Models\UserBehavior;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserBehaviorFactory extends Factory
{
    protected $model = UserBehavior::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'action' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'created_at' => now(),
        ];
    }
} 