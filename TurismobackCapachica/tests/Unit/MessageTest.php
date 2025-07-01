<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Message;
use App\Models\User;
use App\Models\Company;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_message_relations()
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();
        $company = Company::factory()->create();
        $message = Message::factory()->create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'company_id' => $company->id,
        ]);
        $this->assertInstanceOf(User::class, $message->sender);
        $this->assertInstanceOf(User::class, $message->receiver);
        $this->assertInstanceOf(Company::class, $message->company);
    }
} 