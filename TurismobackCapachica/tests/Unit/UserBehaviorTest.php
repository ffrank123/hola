<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\UserBehavior;
use App\Models\User;

class UserBehaviorTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_behavior_relations_and_casts()
    {
        $user = User::factory()->create();
        $behavior = UserBehavior::factory()->create([
            'user_id' => $user->id,
            'preferred_categories' => ['aventura','cultural'],
            'viewed_services' => [1,2],
            'clicked_services' => [3],
            'reserved_services' => [4,5],
            'action' => 'some_action',
        ]);
        $this->assertInstanceOf(User::class, $behavior->user);
        $this->assertIsArray($behavior->preferred_categories);
        $this->assertIsArray($behavior->viewed_services);
        $this->assertIsArray($behavior->clicked_services);
        $this->assertIsArray($behavior->reserved_services);
        $this->assertEquals('some_action', $behavior->action);
    }
} 