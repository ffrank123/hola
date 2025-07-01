<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Location;

class LocationControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_returns_active_communities()
    {
        // Arrange: crear una comunidad activa y otra inactiva
        $active = Location::create([
            'name' => 'Comunidad Activa',
            'type' => 'comunidad',
            'descripcion_corta' => 'desc corta',
            'descripcion_larga' => 'desc larga',
            'atractivos' => 'atractivos',
            'habitantes' => 100,
            'estado' => 'activa',
            'imagen' => 'img.jpg',
            'galeria' => [],
        ]);
        $inactive = Location::create([
            'name' => 'Comunidad Inactiva',
            'type' => 'comunidad',
            'descripcion_corta' => 'desc corta',
            'descripcion_larga' => 'desc larga',
            'atractivos' => 'atractivos',
            'habitantes' => 50,
            'estado' => 'inactiva',
            'imagen' => 'img2.jpg',
            'galeria' => [],
        ]);

        // Act
        $response = $this->getJson('/api/locations');

        // Assert
        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Comunidad Activa'])
                 ->assertJsonMissing(['name' => 'Comunidad Inactiva']);
    }

    /** @test */
    public function show_returns_a_location_if_exists()
    {
        $location = Location::create([
            'name' => 'Comunidad Test',
            'type' => 'comunidad',
            'descripcion_corta' => 'desc corta',
            'descripcion_larga' => 'desc larga',
            'atractivos' => 'atractivos',
            'habitantes' => 100,
            'estado' => 'activa',
            'imagen' => 'img.jpg',
            'galeria' => [],
        ]);

        $response = $this->getJson('/api/locations/' . $location->id);
        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Comunidad Test']);
    }

    /** @test */
    public function show_returns_404_if_location_not_found()
    {
        $response = $this->getJson('/api/locations/9999');
        $response->assertStatus(404)
                 ->assertJsonFragment(['message' => 'Comunidad no encontrada']);
    }
} 