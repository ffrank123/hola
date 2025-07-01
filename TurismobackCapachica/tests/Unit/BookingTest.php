<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Booking;
use App\Models\User;
use App\Models\BookingItem;
use Carbon\Carbon;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_relations_and_casts()
    {
        $user = User::factory()->create();
        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'reservation_date' => '2024-07-01',
            'paid_at' => '2024-07-02 10:00:00',
        ]);
        BookingItem::factory()->create(['booking_id' => $booking->id]);
        $this->assertInstanceOf(User::class, $booking->user);
        $this->assertInstanceOf(Carbon::class, $booking->reservation_date);
        $this->assertInstanceOf(Carbon::class, $booking->paid_at);
        $this->assertCount(1, $booking->items);
    }
} 