<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'reservation_id' => function() {
                $reservation = Reservation::factory()->create();
                return $reservation->id;
            },
            'user_id' => function(array $attributes) {
                if (!empty($attributes['reservation_id'])) {
                    $reservation = \App\Models\Reservation::find($attributes['reservation_id']);
                    return $reservation ? $reservation->user_id : \App\Models\User::factory();
                }
                return \App\Models\User::factory();
            },
            'method' => 'stripe',
            'transaction_id' => $this->faker->uuid(),
            'amount' => $this->faker->randomFloat(2, 10, 500),
            'currency' => 'USD',
            'status' => 'paid',
            'paid_at' => now(),
        ];
    }
} 