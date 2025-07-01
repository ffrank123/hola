<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Review;
use App\Models\Service;

class TuristaReviewControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_user_reviews()
    {
        $user = User::factory()->create();
        $user->assignRole('turista');
        Review::factory()->count(2)->create(['user_id' => $user->id]);
        $this->actingAs($user, 'sanctum');
        $response = $this->getJson('/api/turista/reviews');
        $response->assertStatus(200);
    }

    public function test_store_creates_review()
    {
        $user = User::factory()->create();
        $user->assignRole('turista');
        $service = Service::factory()->create();
        $this->actingAs($user, 'sanctum');
        $payload = [
            'service_id' => $service->id,
            'rating' => 5,
            'comment' => 'Excelente',
        ];
        $response = $this->postJson('/api/turista/reviews', $payload);
        $response->assertStatus(201)->assertJsonFragment(['message' => 'Reseña enviada']);
    }

    public function test_show_returns_review_detail()
    {
        $user = User::factory()->create();
        $user->assignRole('turista');
        $review = Review::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user, 'sanctum');
        $response = $this->getJson('/api/turista/reviews/' . $review->id);
        $response->assertStatus(200);
    }

    public function test_update_modifies_review()
    {
        $user = User::factory()->create();
        $user->assignRole('turista');
        $review = Review::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user, 'sanctum');
        $payload = [
            'rating' => 4,
            'comment' => 'Muy bueno'
        ];
        $response = $this->putJson('/api/turista/reviews/' . $review->id, $payload);
        $response->assertStatus(200)->assertJsonFragment(['message' => 'Reseña actualizada']);
    }

    public function test_destroy_deletes_review()
    {
        $user = User::factory()->create();
        $user->assignRole('turista');
        $review = Review::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user, 'sanctum');
        $response = $this->deleteJson('/api/turista/reviews/' . $review->id);
        $response->assertStatus(204);
    }
} 