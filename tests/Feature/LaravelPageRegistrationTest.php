<?php

namespace Ssh521\LaravelPage\Tests\Feature;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
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

    public function test_admin_page_list_uses_shared_list_design_contract(): void
    {
        $index = File::get(dirname(__DIR__, 2).'/resources/views/admin/pages/index.blade.php');

        $this->assertStringContainsString('x-data="{ filtersOpen: false }"', $index);
        $this->assertStringContainsString('x-laravel-admin::admin.filter-bar', $index);
        $this->assertStringContainsString(':mobile-toggle="false"', $index);
        $this->assertStringContainsString('filtersOpen = ! filtersOpen', $index);
        $this->assertStringContainsString('x-laravel-admin::admin.table-shell', $index);
        $this->assertStringContainsString('x-laravel-admin::admin.action-menu', $index);
        $this->assertStringContainsString('justify-start gap-1 !text-gray-900', $index);
        $this->assertStringContainsString('md:justify-center', $index);
        $this->assertStringContainsString('text-left text-sm font-semibold text-gray-900 sm:pl-0 md:text-center', $index);
        $this->assertStringContainsString('font-semibold whitespace-nowrap text-gray-900', $index);
    }

    private function assertRouteHasMiddleware(string $routeName, string $middleware): void
    {
        $route = Route::getRoutes()->getByName($routeName);

        $this->assertNotNull($route, "Route [{$routeName}] was not registered.");
        $this->assertContains($middleware, $route->gatherMiddleware());
    }
}
