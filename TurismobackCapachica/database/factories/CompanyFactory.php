<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'business_name' => $this->faker->company(),
            'trade_name' => $this->faker->companySuffix(),
            'service_type' => $this->faker->word(),
            'contact_email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'website' => $this->faker->url(),
            'description' => $this->faker->sentence(),
            'logo_url' => null,
            'status' => 'aprobada',
            'verified_at' => now(),
            'ruc' => $this->faker->numerify('20#########'),
            'location_id' => Location::factory(),
        ];
    }
} 