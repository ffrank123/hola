<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\SecurityLog;
use App\Models\User;

class SecurityLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_security_log_user_relation()
    {
        $user = User::factory()->create();
        $log = SecurityLog::factory()->create(['user_id' => $user->id]);
        $this->assertInstanceOf(User::class, $log->user);
    }
} 