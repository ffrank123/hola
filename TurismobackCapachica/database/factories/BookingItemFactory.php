<?php

namespace Database\Factories;

use App\Models\BookingItem;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingItemFactory extends Factory
{
    protected $model = BookingItem::class;

    public function definition()
    {
        return [
            'booking_id' => Booking::factory(),
            'service_id' => Service::factory(),
            'quantity' => $this->faker->numberBetween(1, 5),
            'price_before' => $this->faker->randomFloat(2, 10, 500),
            'price_after' => $this->faker->randomFloat(2, 10, 500),
        ];
    }
} 