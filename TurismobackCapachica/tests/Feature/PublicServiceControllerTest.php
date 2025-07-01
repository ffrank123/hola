<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Service;
use App\Models\Category;

class PublicServiceControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_returns_active_services()
    {
        $category = Category::factory()->create(['name' => 'Aventura']);
        $service = Service::factory()->create([
            'title' => 'Kayak',
            'status' => 'active',
            'category_id' => $category->id,
        ]);
        $inactive = Service::factory()->create([
            'title' => 'Inactive',
            'status' => 'paused',
            'category_id' => $category->id,
        ]);

        $response = $this->getJson('/api/servicios-publicos');
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Kayak'])
            ->assertJsonMissing(['title' => 'Inactive']);
    }

    /** @test */
    public function show_returns_a_service_detail()
    {
        $category = Category::factory()->create(['name' => 'Aventura']);
        $service = Service::factory()->create([
            'title' => 'Kayak',
            'status' => 'active',
            'category_id' => $category->id,
        ]);

        $response = $this->getJson('/api/servicios-publicos/' . $service->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Kayak']);
    }
} 