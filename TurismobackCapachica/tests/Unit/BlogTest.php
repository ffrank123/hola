<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Blog;
use App\Models\Company;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_company_relation()
    {
        $company = Company::factory()->create();
        $blog = Blog::factory()->create(['company_id' => $company->id]);
        $this->assertInstanceOf(Company::class, $blog->company);
    }
} 