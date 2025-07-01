<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'reservation_date' => $this->faker->date(),
            'total_amount' => $this->faker->randomFloat(2, 50, 1000),
            'status' => 'pending',
            'paid_at' => null,
        ];
    }
} 