<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Company;

class SuperadminCompanyManagementControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_pending_lists_pending_companies()
    {
        $superadmin = User::factory()->create();
        $superadmin->assignRole('superadmin');
        Company::factory()->count(2)->create(['status' => 'pendiente']);
        $this->actingAs($superadmin, 'sanctum');
        $response = $this->getJson('/api/superadmin/companies/pending');
        $response->assertStatus(200);
    }

    public function test_approve_company()
    {
        $superadmin = User::factory()->create();
        $superadmin->assignRole('superadmin');
        $company = Company::factory()->create(['status' => 'pendiente']);
        $this->actingAs($superadmin, 'sanctum');
        $response = $this->postJson('/api/superadmin/companies/' . $company->id . '/approve');
        $response->assertStatus(200)->assertJsonFragment(['message' => 'Empresa aprobada']);
    }

    public function test_reject_company()
    {
        $superadmin = User::factory()->create();
        $superadmin->assignRole('superadmin');
        $company = Company::factory()->create(['status' => 'pendiente']);
        $this->actingAs($superadmin, 'sanctum');
        $response = $this->postJson('/api/superadmin/companies/' . $company->id . '/reject');
        $response->assertStatus(200)->assertJsonFragment(['message' => 'Empresa rechazada']);
    }
} 