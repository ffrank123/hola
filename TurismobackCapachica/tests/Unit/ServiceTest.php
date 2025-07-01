<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Service;
use App\Models\Company;
use App\Models\Category;
use App\Models\Location;
use App\Models\Promotion;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_relations()
    {
        $company = Company::factory()->create();
        $category = Category::factory()->create();
        $location = Location::factory()->create();
        $service = Service::factory()->create([
            'company_id' => $company->id,
            'category_id' => $category->id,
            'location_id' => $location->id,
        ]);
        $promo = Promotion::factory()->create();
        $service->promotions()->attach($promo);
        $this->assertInstanceOf(Company::class, $service->company);
        $this->assertInstanceOf(Category::class, $service->category);
        $this->assertInstanceOf(Location::class, $service->zone);
        $this->assertTrue($service->promotions->contains($promo));
    }
} 