<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Company;
use App\Models\User;
use App\Models\Service;
use App\Models\Location;
use App\Models\Promotion;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_relations()
    {
        $user = User::factory()->create();
        $location = Location::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id, 'location_id' => $location->id]);
        $service = Service::factory()->create(['company_id' => $company->id]);
        $promo = Promotion::factory()->create(['company_id' => $company->id]);
        $this->assertInstanceOf(User::class, $company->user);
        $this->assertTrue($company->services->contains($service));
        $this->assertInstanceOf(Location::class, $company->location);
        $this->assertTrue($company->promotions->contains($promo));
    }
} 