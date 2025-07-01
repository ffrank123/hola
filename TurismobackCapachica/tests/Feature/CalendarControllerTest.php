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
        Reservation::factory()->create([
            'service_id' => $service->id,
            'reservation_date' => Carbon::now()->toDateString(),
            'status' => 'confirmed',
        ]);
        $response = $this->getJson('/api/services/' . $service->id . '/calendar');
        $response->assertStatus(200)
            ->assertJsonFragment([Carbon::now()->toDateString()]);
    }
} 