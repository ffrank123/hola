<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Service;
use App\Models\Category;
use App\Models\Location;

class EmprendedorServicioControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_own_services()
    {
        $user = User::factory()->create();
        $user->assignRole('emprendedor');
        $company = Company::factory()->create(['user_id' => $user->id, 'status' => 'aprobada']);
        Service::factory()->count(2)->create(['company_id' => $company->id]);
        $this->actingAs($user, 'sanctum');
        $response = $this->getJson('/api/emprendedor/servicios');
        $response->assertStatus(200);
    }

    public function test_store_creates_service()
    {
        $user = User::factory()->create();
        $user->assignRole('emprendedor');
        $company = Company::factory()->create(['user_id' => $user->id, 'status' => 'aprobada']);
        $category = Category::factory()->create();
        $location = Location::factory()->create();
        $this->actingAs($user, 'sanctum');
        $payload = [
            'company_id' => $company->id,
            'category_id' => $category->id,
            'location_id' => $location->id,
            'title' => 'Servicio Test',
            'slug' => 'servicio-test',
            'description' => 'Descripción de prueba',
            'ubicacion_detallada' => 'Dirección',
            'price' => 100,
            'policy_cancellation' => 'Flexible',
            'capacity' => 5,
            'duration' => '2h',
            'status' => 'active',
            'published_at' => now(),
            'is_active' => true
        ];
        $response = $this->postJson('/api/emprendedor/servicios', $payload);
        $response->assertStatus(201)->assertJsonFragment(['message' => 'Servicio creado exitosamente.']);
    }

    public function test_show_returns_service_detail()
    {
        $user = User::factory()->create();
        $user->assignRole('emprendedor');
        $company = Company::factory()->create(['user_id' => $user->id, 'status' => 'aprobada']);
        $service = Service::factory()->create(['company_id' => $company->id]);
        $this->actingAs($user, 'sanctum');
        $response = $this->getJson('/api/emprendedor/servicios/' . $service->id);
        $response->assertStatus(200);
    }

    public function test_update_modifies_service()
    {
        $user = User::factory()->create();
        $user->assignRole('emprendedor');
        $company = Company::factory()->create(['user_id' => $user->id, 'status' => 'aprobada']);
        $service = Service::factory()->create(['company_id' => $company->id]);
        $this->actingAs($user, 'sanctum');
        $payload = ['title' => 'Nuevo Título'];
        $response = $this->patchJson('/api/emprendedor/servicios/' . $service->id, $payload);
        $response->assertStatus(200)->assertJsonFragment(['message' => 'Servicio actualizado.']);
    }

    public function test_destroy_deletes_service()
    {
        $user = User::factory()->create();
        $user->assignRole('emprendedor');
        $company = Company::factory()->create(['user_id' => $user->id, 'status' => 'aprobada']);
        $service = Service::factory()->create(['company_id' => $company->id]);
        $this->actingAs($user, 'sanctum');
        $response = $this->deleteJson('/api/emprendedor/servicios/' . $service->id);
        $response->assertStatus(204);
    }
} 