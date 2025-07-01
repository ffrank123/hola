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
        $category = Category::create(['name' => 'Aventura']);
        $service = Service::create([
            'name' => 'Kayak',
            'status' => 'active',
            'category_id' => $category->id,
        ]);
        $inactive = Service::create([
            'name' => 'Inactive',
            'status' => 'inactive',
            'category_id' => $category->id,
        ]);

        $response = $this->getJson('/api/servicios-publicos');
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Kayak'])
            ->assertJsonMissing(['name' => 'Inactive']);
    }

    /** @test */
    public function show_returns_a_service_detail()
    {
        $category = Category::create(['name' => 'Aventura']);
        $service = Service::create([
            'name' => 'Kayak',
            'status' => 'active',
            'category_id' => $category->id,
        ]);

        $response = $this->getJson('/api/servicios-publicos/' . $service->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Kayak']);
    }
} 