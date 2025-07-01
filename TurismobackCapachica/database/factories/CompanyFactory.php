<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->company(),
            'business_name' => $this->faker->companySuffix() . ' ' . $this->faker->company(),
            'trade_name' => $this->faker->company(),
            'service_type' => $this->faker->randomElement(['hotel', 'tour', 'restaurant', 'transporte']),
            'contact_email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'website' => $this->faker->url(),
            'description' => $this->faker->paragraph(),
            'ruc' => $this->faker->unique()->numerify('20#########'),
            'logo_url' => $this->faker->imageUrl(),
            'location_id' => Location::factory(),
            'status' => 'aprobada',
            'verified_at' => now(),
        ];
    }
} 