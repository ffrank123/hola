<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\PortalDesign;
use App\Models\Portal;

class PortalDesignTest extends TestCase
{
    use RefreshDatabase;

    public function test_portal_design_relations_and_casts()
    {
        $portal = Portal::factory()->create();
        $design = PortalDesign::factory()->create([
            'portal_id' => $portal->id,
            'slider_images' => json_encode(['img1.jpg','img2.jpg']),
            'colors' => json_encode(['primary'=>'#000']),
            'typography' => json_encode(['font'=>'Arial']),
            'sections' => json_encode(['home','about']),
            'translations' => json_encode(['es'=>'Inicio']),
        ]);
        $this->assertInstanceOf(Portal::class, $design->portal);
        $this->assertIsArray($design->slider_images);
        $this->assertIsArray($design->colors);
        $this->assertIsArray($design->typography);
        $this->assertIsArray($design->sections);
        $this->assertIsArray($design->translations);
    }
} 