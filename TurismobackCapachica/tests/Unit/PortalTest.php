<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Portal;
use App\Models\PortalDesign;

class PortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_portal_design_relation()
    {
        $portal = Portal::factory()->create();
        $design = PortalDesign::factory()->create(['portal_id' => $portal->id]);
        $this->assertInstanceOf(PortalDesign::class, $portal->design);
    }
} 