<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Page;
use App\Models\Portal;

class PageTest extends TestCase
{
    use RefreshDatabase;

    public function test_page_portal_relation()
    {
        $portal = Portal::factory()->create();
        $page = Page::factory()->create(['portal_id' => $portal->id]);
        $this->assertInstanceOf(Portal::class, $page->portal);
    }
} 