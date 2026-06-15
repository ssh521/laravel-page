<?php

namespace Ssh521\LaravelPage\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;
use Ssh521\LaravelPage\Models\Page;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_pages' => Page::query()->count(),
            'published_pages' => Page::query()->where('status', 'published')->count(),
            'draft_pages' => Page::query()->where('status', 'draft')->count(),
            'terms_pages' => Page::query()->whereIn('type', ['terms', 'privacy', 'policy'])->count(),
        ];

        $recentPages = Page::query()
            ->latest()
            ->limit(10)
            ->get();

        return view('laravel-page::admin.dashboard', compact('stats', 'recentPages'));
    }
}
