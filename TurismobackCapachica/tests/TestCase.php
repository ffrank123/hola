<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite']);
        config(['database.connections.sqlite.database' => ':memory:']);
        $this->artisan('migrate');
        $this->artisan('db:seed', ['--class' => 'RolesSeeder']);
    }
}
