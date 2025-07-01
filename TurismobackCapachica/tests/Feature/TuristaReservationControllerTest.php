<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Service;
use Carbon\Carbon;

class TuristaReservationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_user_reservations()
    {
        $user = User::factory()->create();
        Reservation::factory()->count(2)->create(['user_id' => $user->id]);
        $this->actingAs($user, 'sanctum');
        $response = $this->getJson('/api/turista/reservations');
        $response->assertStatus(200);
    }

    public function test_store_creates_reservation()
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();
        $this->actingAs($user, 'sanctum');
        $payload = [
            'service_id' => $service->id,
            'reservation_date' => Carbon::now()->addDay()->toDateString(),
            'people_count' => 2
        ];
        $response = $this->postJson('/api/turista/reservations', $payload);
        $response->assertStatus(201)->assertJsonFragment(['message' => 'Reserva creada']);
    }

    public function test_show_returns_reservation_detail()
    {
        $user = User::factory()->create();
        $reservation = Reservation::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user, 'sanctum');
        $response = $this->getJson('/api/turista/reservations/' . $reservation->id);
        $response->assertStatus(200);
    }

    public function test_update_modifies_reservation()
    {
        $user = User::factory()->create();
        $reservation = Reservation::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user, 'sanctum');
        $payload = [
            'reservation_date' => Carbon::now()->addDays(2)->toDateString(),
            'people_count' => 3
        ];
        $response = $this->putJson('/api/turista/reservations/' . $reservation->id, $payload);
        $response->assertStatus(200)->assertJsonFragment(['message' => 'Reserva actualizada']);
    }

    public function test_destroy_deletes_reservation()
    {
        $user = User::factory()->create();
        $reservation = Reservation::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user, 'sanctum');
        $response = $this->deleteJson('/api/turista/reservations/' . $reservation->id);
        $response->assertStatus(204);
    }

    public function test_pay_reservation()
    {
        $user = User::factory()->create();
        $reservation = Reservation::factory()->create(['user_id' => $user->id, 'status' => 'confirmed']);
        $this->actingAs($user, 'sanctum');
        $response = $this->postJson('/api/turista/reservations/' . $reservation->id . '/pay');
        $response->assertStatus(200)->assertJsonFragment(['message' => 'Reserva pagada y completada correctamente.']);
    }
} 