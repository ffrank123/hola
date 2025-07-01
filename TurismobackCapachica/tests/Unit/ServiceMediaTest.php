<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\ServiceMedia;
use App\Models\Service;

class ServiceMediaTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_media_relation()
    {
        $service = Service::factory()->create();
        $media = ServiceMedia::factory()->create(['service_id' => $service->id]);
        $this->assertInstanceOf(Service::class, $media->service);
    }
} 