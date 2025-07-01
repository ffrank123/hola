<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentMethodFactory extends Factory
{
    protected $model = PaymentMethod::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'card_number' => $this->faker->creditCardNumber(),
            'cardholder_name' => $this->faker->name(),
            'expiry_month' => $this->faker->numberBetween(1, 12),
            'expiry_year' => $this->faker->numberBetween(2024, 2030),
            'cvv' => $this->faker->numberBetween(100, 999),
            'brand' => $this->faker->creditCardType(),
        ];
    }
} 