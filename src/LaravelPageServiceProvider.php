<?php

namespace Ssh521\LaravelPage;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Ssh521\LaravelPage\Console\Commands\InstallCommand;

class LaravelPageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-page.php', 'laravel-page');
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-page');

        $this->registerRoutes();
        $this->registerCommands();
        $this->registerPublishables();
    }

    private function registerRoutes(): void
    {
        Route::middleware('web')->group(function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
            $this->loadRoutesFrom(__DIR__.'/../routes/admin.php');
        });
    }

    private function registerCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            InstallCommand::class,
        ]);
    }

    private function registerPublishables(): void
    {
        $this->publishes([
            __DIR__.'/../config/laravel-page.php' => config_path('laravel-page.php'),
        ], 'laravel-page-config');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'laravel-page-migrations');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-page'),
        ], 'laravel-page-views');

        $this->publishes([
            __DIR__.'/../database/seeders' => database_path('seeders/vendor/laravel-page'),
        ], 'laravel-page-seeders');
    }
}
