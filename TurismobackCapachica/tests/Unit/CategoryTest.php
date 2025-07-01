<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use App\Models\Service;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_services_relation()
    {
        $category = Category::factory()->create();
        $service = Service::factory()->create(['category_id' => $category->id]);
        $this->assertTrue($category->services->contains($service));
    }
} 