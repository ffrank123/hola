<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Service;
use App\Models\Reservation;
use Carbon\Carbon;

class CalendarControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_occupied_dates_for_a_service()
    {
        $service = Service::factory()->create();
        $booking = \App\Models\Booking::factory()->create([
            'reservation_date' => \Carbon\Carbon::now()->toDateString(),
            'status' => 'confirmed',
        ]);
        \App\Models\BookingItem::factory()->create([
            'booking_id' => $booking->id,
            'service_id' => $service->id,
        ]);
        $response = $this->getJson('/api/services/' . $service->id . '/calendar');
        $response->assertStatus(200)
            ->assertJsonFragment([\Carbon\Carbon::now()->toDateString()]);
    }
} 