<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Service;
use App\Models\Payment;
use Carbon\Carbon;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_reservation_relations_and_casts()
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();
        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'service_id' => $service->id,
            'reservation_date' => '2024-07-01',
            'paid_at' => '2024-07-02 10:00:00',
        ]);
        $payment = Payment::factory()->create(['reservation_id' => $reservation->id, 'method' => 'stripe']);
        $this->assertInstanceOf(User::class, $reservation->user);
        $this->assertInstanceOf(Service::class, $reservation->service);
        $this->assertInstanceOf(Payment::class, $reservation->payment);
        $this->assertInstanceOf(Carbon::class, $reservation->reservation_date);
        $this->assertInstanceOf(Carbon::class, $reservation->paid_at);
    }
} 