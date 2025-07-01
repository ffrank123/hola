<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Location;
use App\Models\Company;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    public function test_location_relations_and_casts()
    {
        $location = Location::factory()->create(['galeria' => ['img1.jpg','img2.jpg']]);
        $company = Company::factory()->create(['location_id' => $location->id]);
        $this->assertTrue($location->companies->contains($company));
        $this->assertIsArray($location->galeria);
    }
} 