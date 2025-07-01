<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Promotion;
use Carbon\Carbon;

class PromotionTest extends TestCase
{
    use RefreshDatabase;

    public function test_scope_active_returns_only_active_and_valid_promotions()
    {
        $active = Promotion::factory()->create([
            'status' => 'active',
            'start_date' => Carbon::now()->subDay(),
            'end_date' => Carbon::now()->addDay(),
        ]);
        $inactive = Promotion::factory()->create([
            'status' => 'inactive',
            'start_date' => Carbon::now()->subDay(),
            'end_date' => Carbon::now()->addDay(),
        ]);
        $expired = Promotion::factory()->create([
            'status' => 'active',
            'start_date' => Carbon::now()->subDays(10),
            'end_date' => Carbon::now()->subDay(),
        ]);
        $result = Promotion::active()->get();
        $this->assertTrue($result->contains($active));
        $this->assertFalse($result->contains($inactive));
        $this->assertFalse($result->contains($expired));
    }

    public function test_dates_are_casted_to_carbon()
    {
        $promo = Promotion::factory()->create([
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
        ]);
        $this->assertInstanceOf(Carbon::class, $promo->start_date);
        $this->assertInstanceOf(Carbon::class, $promo->end_date);
    }
} 