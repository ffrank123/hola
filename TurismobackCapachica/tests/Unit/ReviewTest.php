<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Review;
use App\Models\User;
use App\Models\Service;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_review_relations()
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();
        $review = Review::factory()->create(['user_id' => $user->id, 'service_id' => $service->id]);
        $this->assertInstanceOf(User::class, $review->user);
        $this->assertInstanceOf(Service::class, $review->service);
    }
} 