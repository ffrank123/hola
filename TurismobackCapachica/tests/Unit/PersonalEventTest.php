<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\PersonalEvent;
use App\Models\Company;

class PersonalEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_personal_event_relation()
    {
        $company = Company::factory()->create();
        $event = PersonalEvent::factory()->create(['company_id' => $company->id]);
        $this->assertInstanceOf(Company::class, $event->company);
    }
} 