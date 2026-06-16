<?php

namespace Ssh521\LaravelPage\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ssh521\LaravelPage\Models\Page;
use Ssh521\LaravelPage\Models\PageVersion;

class PageVersionController extends Controller
{
    public function index(Page $page): View
    {
        $versions = $page->versions()->latest()->paginate(20);
        $publishedVersion = $page->versions()
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->first();

        return view('laravel-page::admin.versions.index', compact('page', 'versions', 'publishedVersion'));
    }

    public function store(Request $request, Page $page): RedirectResponse
    {
        $data = $request->validate([
            'version_label' => ['nullable', 'string', 'max:255'],
            'effective_date' => ['nullable', 'date'],
            'summary' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
        ]);

        $page->versions()->create([
            ...$data,
            'summary' => $data['summary'] ?? $page->summary,
            'body' => $data['body'] ?? $page->body,
            'meta' => [
                'meta_title' => $page->meta_title,
                'meta_description' => $page->meta_description,
                'og_title' => $page->og_title,
                'og_description' => $page->og_description,
                'og_image_path' => $page->og_image_path,
            ],
        ]);

        return redirect()
            ->route('page.admin.versions.index', $page)
            ->with('success', '버전이 저장되었습니다.');
    }

    public function publish(Page $page, PageVersion $version): RedirectResponse
    {
        abort_unless($version->page_id === $page->id, 404);

        $version->update(['published_at' => now()]);
        $page->update([
            'summary' => $version->summary,
            'body' => $version->body,
            'status' => 'published',
            'published_at' => now(),
        ]);

        return redirect()
            ->route('page.admin.versions.index', $page)
            ->with('success', '버전이 공개되었습니다.');
    }
}
