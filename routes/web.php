<?php

use Illuminate\Support\Facades\Route;
use Ssh521\LaravelPage\Http\Controllers\PageController;

$publicPrefix = trim(config('laravel-page.prefix.web', 'pages'), '/');
$aliases = config('laravel-page.routes.aliases', []);

foreach ($aliases as $alias => $slug) {
    Route::middleware(config('laravel-page.routes.public_middleware', ['web']))
        ->get($alias, [PageController::class, 'showAlias'])
        ->defaults('slug', $slug)
        ->name("laravel-page.alias.{$alias}");
}

Route::middleware(config('laravel-page.routes.public_middleware', ['web']))
    ->prefix($publicPrefix)
    ->name('laravel-page.')
    ->group(function () {
        Route::get('/{slug}', [PageController::class, 'show'])->name('show');
    });

if ((bool) config('laravel-page.routes.use_root_slugs', false)) {
    Route::middleware(config('laravel-page.routes.public_middleware', ['web']))
        ->get('/{slug}', [PageController::class, 'show'])
        ->name('laravel-page.root.show');
}
