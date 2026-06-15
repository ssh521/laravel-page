<?php

namespace Ssh521\LaravelPage\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Livewire\LivewireServiceProvider;
use Ssh521\LaravelAdmin\LaravelAdminServiceProvider;
use Ssh521\LaravelFile\LaravelFileServiceProvider;
use Ssh521\LaravelPage\LaravelPageServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            LaravelAdminServiceProvider::class,
            LaravelFileServiceProvider::class,
            LaravelPageServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}
