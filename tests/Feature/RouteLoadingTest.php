<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RouteLoadingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Clear and re-cache routes to ensure fresh loading in test environment
        Artisan::call('route:clear');
        Artisan::call('route:cache');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
    }

    /** @test */
    public function all_application_routes_are_loaded()
    {
        $this->withoutExceptionHandling();

        $routes = Route::getRoutes()->getRoutesByName();

        echo "\n--- Registered Routes ---\n";
        foreach ($routes as $name => $route) {
            echo "Route Name: " . $name . "\n";
        }
        echo "--- End Registered Routes ---\n";

        // Assert that specific routes are loaded
        $this->assertArrayHasKey('admin.admin.dashboard', $routes);
        $this->assertArrayHasKey('vendor.vendor.properties.index', $routes);
        $this->assertArrayHasKey('pm-team.pm-team.inspections.index', $routes);
        $this->assertArrayHasKey('renter.renter.properties.index', $routes);
        $this->assertTrue(true);
    }
}
