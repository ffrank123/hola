<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\BookingItem;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Promotion;

class BookingItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_item_relations()
    {
        $booking = Booking::factory()->create();
        $service = Service::factory()->create();
        $promotion = Promotion::factory()->create();
        $item = BookingItem::factory()->create([
            'booking_id' => $booking->id,
            'service_id' => $service->id,
            'promotion_id' => $promotion->id,
        ]);
        $this->assertInstanceOf(Booking::class, $item->booking);
        $this->assertInstanceOf(Service::class, $item->service);
        $this->assertInstanceOf(Promotion::class, $item->promotion);
    }
} 