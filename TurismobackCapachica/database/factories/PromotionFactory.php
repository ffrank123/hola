<?php

namespace Database\Factories;

use App\Models\Promotion;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class PromotionFactory extends Factory
{
    protected $model = Promotion::class;

    public function definition()
    {
        return [
            'company_id' => Company::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'discount_percentage' => $this->faker->numberBetween(5, 50),
            'start_date' => Carbon::now()->subDays(2),
            'end_date' => Carbon::now()->addDays(5),
            'status' => 'active',
        ];
    }
} 