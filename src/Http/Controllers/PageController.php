<?php

namespace Ssh521\LaravelPage\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;
use Ssh521\LaravelPage\Models\Page;

class PageController extends Controller
{
    public function show(string $slug): View
    {
        $page = Page::query()
            ->published()
            ->where('slug', $slug)
            ->with('sections')
            ->firstOrFail();

        return view('laravel-page::pages.show', [
            'page' => $page,
            'meta' => $this->meta($page),
        ]);
    }

    public function showAlias(string $slug): View
    {
        return $this->show($slug);
    }

    /**
     * @return array<string, string|null>
     */
    private function meta(Page $page): array
    {
        return [
            'title' => $page->metaTitle(),
            'description' => $page->metaDescription(),
            'canonical_url' => $page->canonical_url,
            'og_title' => $page->og_title ?: $page->metaTitle(),
            'og_description' => $page->og_description ?: $page->metaDescription(),
            'og_image' => $page->og_image_path,
        ];
    }
}
