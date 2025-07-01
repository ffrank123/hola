<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Promotion;
use App\Models\Service;
use Carbon\Carbon;

class EmprendedorPromotionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_promotions()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $promo = Promotion::factory()->create(['company_id' => $company->id]);
        $this->actingAs($user, 'sanctum');
        $response = $this->getJson('/api/emprendedor/promotions');
        $response->assertStatus(200);
    }

    public function test_store_creates_promotion()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $service = Service::factory()->create(['company_id' => $company->id]);
        $this->actingAs($user, 'sanctum');
        $payload = [
            'title' => 'Promo Test',
            'discount_percentage' => 10,
            'start_date' => Carbon::now()->toDateString(),
            'end_date' => Carbon::now()->addDay()->toDateString(),
            'status' => 'active',
            'service_ids' => [$service->id],
        ];
        $response = $this->postJson('/api/emprendedor/promotions', $payload);
        $response->assertStatus(201);
    }

    public function test_show_returns_promotion_detail()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $promo = Promotion::factory()->create(['company_id' => $company->id]);
        $this->actingAs($user, 'sanctum');
        $response = $this->getJson('/api/emprendedor/promotions/' . $promo->id);
        $response->assertStatus(200);
    }

    public function test_update_modifies_promotion()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $promo = Promotion::factory()->create(['company_id' => $company->id]);
        $this->actingAs($user, 'sanctum');
        $payload = ['title' => 'Promo Actualizada'];
        $response = $this->putJson('/api/emprendedor/promotions/' . $promo->id, $payload);
        $response->assertStatus(200);
    }

    public function test_destroy_deletes_promotion()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $promo = Promotion::factory()->create(['company_id' => $company->id]);
        $this->actingAs($user, 'sanctum');
        $response = $this->deleteJson('/api/emprendedor/promotions/' . $promo->id);
        $response->assertStatus(204);
    }
} 