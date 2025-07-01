<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Service;
use App\Models\Booking;

class EmprendedorBookingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_bookings_for_own_services()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $service = Service::factory()->create(['company_id' => $company->id]);
        $booking = Booking::factory()->create();
        $booking->items()->create(['service_id' => $service->id, 'type' => 'service', 'quantity' => 1]);
        $this->actingAs($user, 'sanctum');
        $response = $this->getJson('/api/emprendedor/bookings');
        $response->assertStatus(200);
    }

    public function test_show_returns_booking_detail_if_owned()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $service = Service::factory()->create(['company_id' => $company->id]);
        $booking = Booking::factory()->create();
        $booking->items()->create(['service_id' => $service->id, 'type' => 'service', 'quantity' => 1]);
        $this->actingAs($user, 'sanctum');
        $response = $this->getJson('/api/emprendedor/bookings/' . $booking->id);
        $response->assertStatus(200);
    }

    public function test_update_status_of_booking()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $service = Service::factory()->create(['company_id' => $company->id]);
        $booking = Booking::factory()->create(['status' => 'pending']);
        $booking->items()->create(['service_id' => $service->id, 'type' => 'service', 'quantity' => 1]);
        $this->actingAs($user, 'sanctum');
        $response = $this->putJson('/api/emprendedor/bookings/' . $booking->id . '/status', ['status' => 'confirmed']);
        $response->assertStatus(200);
    }
} 