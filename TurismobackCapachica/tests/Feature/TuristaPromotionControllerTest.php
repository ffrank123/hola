<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Promotion;
use App\Models\Service;
use Carbon\Carbon;

class TuristaPromotionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_active_promotions_with_services()
    {
        $user = User::factory()->create();
        $service = Service::factory()->create(['price' => 100]);
        $promo = Promotion::factory()->create([
            'title' => 'Promo 1',
            'status' => 'active',
            'discount_percentage' => 10,
            'start_date' => Carbon::now()->subDay(),
            'end_date' => Carbon::now()->addDay(),
        ]);
        $promo->services()->attach($service);
        $this->actingAs($user, 'api');
        $response = $this->getJson('/api/turista/promotions');
        $response->assertStatus(200)->assertJsonFragment(['title' => 'Promo 1']);
    }
} 