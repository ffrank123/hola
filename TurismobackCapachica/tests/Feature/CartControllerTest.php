<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use App\Models\Service;
use App\Models\Promotion;
use App\Models\Category;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_add_service_to_cart()
    {
        $category = Category::create(['name' => 'Aventura']);
        $service = Service::create([
            'name' => 'Kayak',
            'title' => 'Kayak',
            'price' => 100,
            'status' => 'active',
            'category_id' => $category->id,
        ]);
        $response = $this->postJson('/api/cart/service/' . $service->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Kayak']);
    }

    /** @test */
    public function can_view_cart()
    {
        Session::start();
        session(['cart' => [
            ['type' => 'service', 'id' => 1, 'title' => 'Kayak', 'price' => 100, 'quantity' => 1]
        ]]);
        $response = $this->getJson('/api/cart');
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Kayak']);
    }

    /** @test */
    public function can_remove_item_from_cart()
    {
        Session::start();
        session(['cart' => [
            ['type' => 'service', 'id' => 1, 'title' => 'Kayak', 'price' => 100, 'quantity' => 1]
        ]]);
        $response = $this->deleteJson('/api/cart/service/1');
        $response->assertStatus(200)
            ->assertJsonMissing(['title' => 'Kayak']);
    }

    /** @test */
    public function can_clear_cart()
    {
        Session::start();
        session(['cart' => [
            ['type' => 'service', 'id' => 1, 'title' => 'Kayak', 'price' => 100, 'quantity' => 1]
        ]]);
        $response = $this->postJson('/api/cart/clear');
        $response->assertStatus(200)
            ->assertJsonFragment(['cart' => []]);
    }
} 