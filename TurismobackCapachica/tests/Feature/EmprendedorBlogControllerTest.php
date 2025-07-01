<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Blog;

class EmprendedorBlogControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_own_posts()
    {
        $user = User::factory()->create();
        $user->assignRole('emprendedor');
        $company = Company::factory()->create(['user_id' => $user->id]);
        Blog::factory()->count(2)->create(['company_id' => $company->id]);
        $this->actingAs($user, 'sanctum');
        $response = $this->getJson('/api/emprendedor/blogs');
        $response->assertStatus(200);
    }

    public function test_store_creates_post()
    {
        $user = User::factory()->create();
        $user->assignRole('emprendedor');
        $company = Company::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user, 'sanctum');
        $payload = [
            'title' => 'Post Test',
            'content' => 'Contenido',
        ];
        $response = $this->postJson('/api/emprendedor/blogs', $payload);
        $response->assertStatus(201)->assertJsonFragment(['message' => 'Post creado exitosamente.']);
    }

    public function test_show_returns_post_detail()
    {
        $user = User::factory()->create();
        $user->assignRole('emprendedor');
        $company = Company::factory()->create(['user_id' => $user->id]);
        $post = Blog::factory()->create(['company_id' => $company->id]);
        $this->actingAs($user, 'sanctum');
        $response = $this->getJson('/api/emprendedor/blogs/' . $post->id);
        $response->assertStatus(200);
    }

    public function test_update_modifies_post()
    {
        $user = User::factory()->create();
        $user->assignRole('emprendedor');
        $company = Company::factory()->create(['user_id' => $user->id]);
        $post = Blog::factory()->create(['company_id' => $company->id]);
        $this->actingAs($user, 'sanctum');
        $payload = ['title' => 'Nuevo Título'];
        $response = $this->putJson('/api/emprendedor/blogs/' . $post->id, $payload);
        $response->assertStatus(200)->assertJsonFragment(['message' => 'Post actualizado.']);
    }

    public function test_destroy_deletes_post()
    {
        $user = User::factory()->create();
        $user->assignRole('emprendedor');
        $company = Company::factory()->create(['user_id' => $user->id]);
        $post = Blog::factory()->create(['company_id' => $company->id]);
        $this->actingAs($user, 'sanctum');
        $response = $this->deleteJson('/api/emprendedor/blogs/' . $post->id);
        $response->assertStatus(204);
    }
} 