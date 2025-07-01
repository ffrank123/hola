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
        $superadmin = User::factory()->create();
        $superadmin->assignRole('superadmin');
        User::factory()->count(2)->create()->each(function($user) {
            $user->assignRole('turista');
        });
        $this->actingAs($superadmin, 'sanctum');
        $response = $this->getJson('/api/superadmin/turistas');
        $response->assertStatus(200);
    }

    public function test_show_returns_turista_detail()
    {
        $superadmin = User::factory()->create();
        $superadmin->assignRole('superadmin');
        $turista = User::factory()->create();
        $turista->assignRole('turista');
        $this->actingAs($superadmin, 'sanctum');
        $response = $this->getJson('/api/superadmin/turistas/' . $turista->id);
        $response->assertStatus(200);
    }

    public function test_update_status_of_turista()
    {
        $superadmin = User::factory()->create();
        $superadmin->assignRole('superadmin');
        $turista = User::factory()->create(['estado' => 'activo']);
        $turista->assignRole('turista');
        $this->actingAs($superadmin, 'sanctum');
        $response = $this->putJson('/api/superadmin/turistas/' . $turista->id . '/status', ['estado' => 'suspendido']);
        $response->assertStatus(200)->assertJsonFragment(['estado' => 'suspendido']);
    }

    public function test_send_message_to_turista()
    {
        $superadmin = User::factory()->create();
        $superadmin->assignRole('superadmin');
        $turista = User::factory()->create();
        $turista->assignRole('turista');
        $this->actingAs($superadmin, 'sanctum');
        $response = $this->postJson('/api/superadmin/turistas/' . $turista->id . '/mensaje', ['mensaje' => 'Hola!']);
        $response->assertStatus(200)->assertJsonFragment(['message' => 'Mensaje enviado correctamente.']);
    }
} 