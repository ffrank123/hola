<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Service;
use Carbon\Carbon;

class CheckoutControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_checkout_with_service_cart()
    {
        $user = User::factory()->create();
        $service = Service::factory()->create(['price' => 100]);
        $cart = [
            [
                'type' => 'service',
                'id' => $service->id,
                'quantity' => 2,
            ]
        ];
        $payload = [
            'reservation_date' => Carbon::now()->addDay()->toDateString(),
            'cart' => $cart,
        ];
        $response = $this->actingAs($user)->postJson('/api/checkout', $payload);
        $response->assertStatus(201)
            ->assertJsonFragment(['message' => 'Booking creado exitosamente.'])
            ->assertJsonStructure(['booking' => ['id', 'user_id', 'reservation_date', 'total_amount', 'status', 'items']]);
    }
} 