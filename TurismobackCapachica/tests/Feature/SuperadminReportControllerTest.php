<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class SuperadminReportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_sales_by_returns_data()
    {
        $superadmin = User::factory()->create();
        $superadmin->assignRole('superadmin');
        $this->actingAs($superadmin, 'sanctum');
        $response = $this->getJson('/api/superadmin/reports/sales-by');
        $response->assertStatus(200);
    }

    public function test_usage_metrics_returns_data()
    {
        $superadmin = User::factory()->create();
        $superadmin->assignRole('superadmin');
        $this->actingAs($superadmin, 'sanctum');
        $response = $this->getJson('/api/superadmin/reports/usage-metrics');
        $response->assertStatus(200);
    }
} 