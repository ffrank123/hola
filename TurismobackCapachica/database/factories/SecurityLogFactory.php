<?php

namespace Database\Factories;

use App\Models\SecurityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SecurityLogFactory extends Factory
{
    protected $model = SecurityLog::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'action' => $this->faker->word(),
            'ip_address' => $this->faker->ipv4(),
            'created_at' => now(),
        ];
    }
} 