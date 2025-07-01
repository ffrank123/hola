<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Booking;
use App\Models\PaymentMethod;

class TuristaBookingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_user_bookings()
    {
        $user = User::factory()->create();
        $user->assignRole('turista');
        Booking::factory()->count(2)->create(['user_id' => $user->id]);
        $this->actingAs($user, 'sanctum');
        $response = $this->getJson('/api/turista/bookings');
        $response->assertStatus(200)->assertJsonStructure(['data']);
    }

    public function test_show_returns_booking_detail()
    {
        $user = User::factory()->create();
        $user->assignRole('turista');
        $booking = Booking::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user, 'sanctum');
        $response = $this->getJson('/api/turista/bookings/' . $booking->id);
        $response->assertStatus(200)->assertJsonFragment(['id' => $booking->id]);
    }

    public function test_pay_booking()
    {
        $user = User::factory()->create();
        $user->assignRole('turista');
        $booking = Booking::factory()->create(['user_id' => $user->id, 'status' => 'confirmed']);
        $payment = PaymentMethod::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user, 'sanctum');
        $response = $this->postJson('/api/turista/bookings/' . $booking->id . '/pay', [
            'payment_method_id' => $payment->id
        ]);
        $response->assertStatus(200)->assertJsonFragment(['message' => 'Pago realizado correctamente']);
    }
} 