<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Company;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\UserBehavior;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_scope_turistas_returns_only_turistas()
    {
        $turista = User::factory()->create();
        $admin = User::factory()->create();
        $result = User::turistas()->get();
        $this->assertTrue($result->contains($turista));
        $this->assertFalse($result->contains($admin));
    }

    public function test_user_relations()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $reservation = Reservation::factory()->create(['user_id' => $user->id]);
        $review = Review::factory()->create(['user_id' => $user->id]);
        $behavior = UserBehavior::factory()->create(['user_id' => $user->id]);
        $this->assertInstanceOf(Company::class, $user->company);
        $this->assertTrue($user->reservations->contains($reservation));
        $this->assertTrue($user->reviews->contains($review));
        $this->assertInstanceOf(UserBehavior::class, $user->behaviors);
    }

    public function test_average_rating_accessor()
    {
        $user = User::factory()->create();
        Review::factory()->create(['user_id' => $user->id, 'rating' => 4]);
        Review::factory()->create(['user_id' => $user->id, 'rating' => 5]);
        $this->assertEquals(4.5, $user->average_rating);
    }
} 