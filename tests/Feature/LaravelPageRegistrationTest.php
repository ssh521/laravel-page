<?php

namespace Ssh521\LaravelPage\Tests\Feature;

use Illuminate\Support\Facades\Route;
use Ssh521\LaravelPage\Tests\TestCase;

class LaravelPageRegistrationTest extends TestCase
{
    public function test_package_routes_are_registered(): void
    {
        $this->assertNotNull(Route::getRoutes()->getByName('laravel-page.show'));
        $this->assertNotNull(Route::getRoutes()->getByName('page.admin.dashboard'));
        $this->assertNotNull(Route::getRoutes()->getByName('page.admin.pages.index'));
    }

    public function test_admin_routes_have_permission_middleware(): void
    {
        $this->assertRouteHasMiddleware('page.admin.dashboard', 'can:laravel-page-dashboard-access');
        $this->assertRouteHasMiddleware('page.admin.pages.index', 'can:laravel-page-pages-view');
        $this->assertRouteHasMiddleware('page.admin.pages.create', 'can:laravel-page-pages-create');
        $this->assertRouteHasMiddleware('page.admin.pages.edit', 'can:laravel-page-pages-update');
    }

    private function assertRouteHasMiddleware(string $routeName, string $middleware): void
    {
        $route = Route::getRoutes()->getByName($routeName);

        $this->assertNotNull($route, "Route [{$routeName}] was not registered.");
        $this->assertContains($middleware, $route->gatherMiddleware());
    }
}
