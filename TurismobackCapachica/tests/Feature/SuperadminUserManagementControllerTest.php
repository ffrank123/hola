<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class SuperadminUserManagementControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_lists_turistas()
    {
        $superadmin = User::factory()->create(['role' => 'superadmin']);
        User::factory()->count(2)->create(['role' => 'turista']);
        $this->actingAs($superadmin, 'sanctum');
        $response = $this->getJson('/api/superadmin/users');
        $response->assertStatus(200);
    }

    public function test_show_returns_turista_detail()
    {
        $superadmin = User::factory()->create(['role' => 'superadmin']);
        $turista = User::factory()->create(['role' => 'turista']);
        $this->actingAs($superadmin, 'sanctum');
        $response = $this->getJson('/api/superadmin/users/' . $turista->id);
        $response->assertStatus(200);
    }

    public function test_update_status_of_turista()
    {
        $superadmin = User::factory()->create(['role' => 'superadmin']);
        $turista = User::factory()->create(['role' => 'turista', 'estado' => 'activo']);
        $this->actingAs($superadmin, 'sanctum');
        $response = $this->putJson('/api/superadmin/users/' . $turista->id . '/status', ['estado' => 'suspendido']);
        $response->assertStatus(200)->assertJsonFragment(['estado' => 'suspendido']);
    }

    public function test_send_message_to_turista()
    {
        $superadmin = User::factory()->create(['role' => 'superadmin']);
        $turista = User::factory()->create(['role' => 'turista']);
        $this->actingAs($superadmin, 'sanctum');
        $response = $this->postJson('/api/superadmin/users/' . $turista->id . '/message', ['mensaje' => 'Hola!']);
        $response->assertStatus(200)->assertJsonFragment(['message' => 'Mensaje enviado correctamente.']);
    }
} 