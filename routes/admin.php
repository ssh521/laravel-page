<?php

use Illuminate\Support\Facades\Route;
use Ssh521\LaravelPage\Http\Controllers\Admin\DashboardController;
use Ssh521\LaravelPage\Http\Controllers\Admin\PageController;
use Ssh521\LaravelPage\Http\Controllers\Admin\PageVersionController;

$prefix = trim(config('laravel-admin.route_prefix', 'admin'), '/').'/'.trim(config('laravel-page.prefix.admin', 'pages'), '/');
$middleware = config('laravel-page.admin.middleware') ?: config('laravel-admin.middleware', ['web', 'auth', 'verified']);

Route::prefix($prefix)->name('page.admin.')->middleware($middleware)->group(function () {
    Route::get('/', [DashboardController::class, 'index'])
        ->middleware('can:laravel-page-dashboard-access')
        ->name('dashboard');

    Route::get('/list', [PageController::class, 'index'])
        ->middleware('can:laravel-page-pages-view')
        ->name('pages.index');
    Route::get('/create', [PageController::class, 'create'])
        ->middleware('can:laravel-page-pages-create')
        ->name('pages.create');
    Route::post('/', [PageController::class, 'store'])
        ->middleware('can:laravel-page-pages-create')
        ->name('pages.store');
    Route::get('/{page}', [PageController::class, 'show'])
        ->middleware('can:laravel-page-pages-view')
        ->name('pages.show');
    Route::get('/{page}/edit', [PageController::class, 'edit'])
        ->middleware('can:laravel-page-pages-update')
        ->name('pages.edit');
    Route::put('/{page}', [PageController::class, 'update'])
        ->middleware('can:laravel-page-pages-update')
        ->name('pages.update');
    Route::delete('/{page}', [PageController::class, 'destroy'])
        ->middleware('can:laravel-page-pages-delete')
        ->name('pages.destroy');

    Route::get('/{page}/versions', [PageVersionController::class, 'index'])
        ->middleware('can:laravel-page-pages-view')
        ->name('versions.index');
    Route::post('/{page}/versions', [PageVersionController::class, 'store'])
        ->middleware('can:laravel-page-terms-publish')
        ->name('versions.store');
    Route::post('/{page}/versions/{version}/publish', [PageVersionController::class, 'publish'])
        ->middleware('can:laravel-page-terms-publish')
        ->name('versions.publish');
});
