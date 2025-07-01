<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\PaymentMethod;
use App\Models\User;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_method_user_relation()
    {
        $user = User::factory()->create();
        $method = PaymentMethod::factory()->create(['user_id' => $user->id]);
        $this->assertInstanceOf(User::class, $method->user);
    }
} 