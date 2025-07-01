<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Payment;
use App\Models\Reservation;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_relation()
    {
        $reservation = Reservation::factory()->create();
        $payment = Payment::factory()->create(['reservation_id' => $reservation->id]);
        $this->assertInstanceOf(Reservation::class, $payment->reservation);
    }
} 