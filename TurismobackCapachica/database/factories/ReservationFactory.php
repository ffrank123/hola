<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'service_id' => Service::factory(),
            'reservation_date' => $this->faker->date(),
            'people_count' => $this->faker->numberBetween(1, 10),
            'total_amount' => $this->faker->randomFloat(2, 50, 1000),
            'status' => 'pending',
            'paid_at' => null,
        ];
    }
} 