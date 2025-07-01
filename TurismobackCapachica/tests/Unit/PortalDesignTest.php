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
            'slider_images' => ['img1.jpg','img2.jpg'],
            'colors' => ['primary'=>'#000'],
            'typography' => ['font'=>'Arial'],
            'sections' => ['home','about'],
            'translations' => ['es'=>'Inicio'],
        ]);
        $this->assertInstanceOf(Portal::class, $design->portal);
        $this->assertIsArray($design->slider_images);
        $this->assertIsArray($design->colors);
        $this->assertIsArray($design->typography);
        $this->assertIsArray($design->sections);
        $this->assertIsArray($design->translations);
    }
} 