<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Promotion;
use App\Models\Service;
use Carbon\Carbon;

class PublicPromotionControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_returns_active_promotions()
    {
        $service = Service::factory()->create(['price' => 100]);
        $promo = Promotion::factory()->create([
            'title' => 'Promo 1',
            'status' => 'active',
            'discount_percentage' => 10,
            'start_date' => Carbon::now()->subDay(),
            'end_date' => Carbon::now()->addDay(),
        ]);
        $promo->services()->attach($service);

        $response = $this->getJson('/api/promociones-publicas');
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Promo 1'])
            ->assertJsonFragment(['discount_percentage' => '10.00']);
    }
} 