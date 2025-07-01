<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoogleAuthTest extends TestCase
{
    /**
     * Testea que la ruta de Google redirige correctamente (cubre lógica del controlador).
     */
    public function test_google_redirect_route_works()
    {
        $response = $this->get('/auth/google');
        $response->assertStatus(302); // Redirección a Google
    }
} 