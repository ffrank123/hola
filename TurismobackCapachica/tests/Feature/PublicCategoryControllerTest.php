<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;

class PublicCategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_returns_all_categories()
    {
        $cat1 = Category::create(['name' => 'Aventura']);
        $cat2 = Category::create(['name' => 'Cultural']);

        $response = $this->getJson('/api/categorias-publicas');
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Aventura'])
            ->assertJsonFragment(['name' => 'Cultural']);
    }
} 