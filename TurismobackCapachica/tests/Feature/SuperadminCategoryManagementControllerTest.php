<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;

class SuperadminCategoryManagementControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_lists_categories()
    {
        $superadmin = User::factory()->create(['role' => 'superadmin']);
        Category::factory()->count(2)->create();
        $this->actingAs($superadmin, 'sanctum');
        $response = $this->getJson('/api/superadmin/experiencias/categorias');
        $response->assertStatus(200);
    }

    public function test_store_creates_category()
    {
        $superadmin = User::factory()->create(['role' => 'superadmin']);
        $this->actingAs($superadmin, 'sanctum');
        $payload = [
            'name' => 'Nueva Categoria',
            'status' => 'active',
        ];
        $response = $this->postJson('/api/superadmin/experiencias/categorias', $payload);
        $response->assertStatus(201)->assertJsonFragment(['message' => 'Categoría creada con éxito.']);
    }

    public function test_update_modifies_category()
    {
        $superadmin = User::factory()->create(['role' => 'superadmin']);
        $category = Category::factory()->create();
        $this->actingAs($superadmin, 'sanctum');
        $payload = ['name' => 'Actualizada', 'status' => 'inactive'];
        $response = $this->putJson('/api/superadmin/experiencias/categorias/' . $category->id, $payload);
        $response->assertStatus(200)->assertJsonFragment(['message' => 'Categoría actualizada correctamente.']);
    }

    public function test_destroy_deletes_category()
    {
        $superadmin = User::factory()->create(['role' => 'superadmin']);
        $category = Category::factory()->create();
        $this->actingAs($superadmin, 'sanctum');
        $response = $this->deleteJson('/api/superadmin/experiencias/categorias/' . $category->id);
        $response->assertStatus(200)->assertJsonFragment(['message' => 'Categoría eliminada correctamente.']);
    }
} 