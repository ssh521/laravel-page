<?php

namespace Ssh521\LaravelPage\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ssh521\LaravelPage\Http\Requests\Admin\StorePageRequest;
use Ssh521\LaravelPage\Http\Requests\Admin\UpdatePageRequest;
use Ssh521\LaravelPage\Models\Page;

class PageController extends Controller
{
    public function index(Request $request): View
    {
        $pages = Page::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('summary', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('type'), fn ($query) => $query->where('type', $request->string('type')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->orderBy('sort_order')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('laravel-page::admin.pages.index', [
            'pages' => $pages,
            'types' => config('laravel-page.types', []),
            'statuses' => config('laravel-page.statuses', []),
        ]);
    }

    public function create(): View
    {
        return view('laravel-page::admin.pages.create', [
            'page' => new Page(['type' => 'page', 'status' => 'draft']),
            'types' => config('laravel-page.types', []),
            'statuses' => config('laravel-page.statuses', []),
        ]);
    }

    public function store(StorePageRequest $request): RedirectResponse
    {
        $data = $this->pageData($request->validated());
        $page = Page::create($data);

        return redirect()
            ->route('page.admin.pages.edit', $page)
            ->with('success', '페이지가 생성되었습니다.');
    }

    public function show(Page $page): View
    {
        $page->load(['versions' => fn ($query) => $query->latest(), 'sections']);

        return view('laravel-page::admin.pages.show', compact('page'));
    }

    public function edit(Page $page): View
    {
        return view('laravel-page::admin.pages.edit', [
            'page' => $page,
            'types' => config('laravel-page.types', []),
            'statuses' => config('laravel-page.statuses', []),
        ]);
    }

    public function update(UpdatePageRequest $request, Page $page): RedirectResponse
    {
        $page->update($this->pageData($request->validated()));

        return redirect()
            ->route('page.admin.pages.edit', $page)
            ->with('success', '페이지가 수정되었습니다.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        $page->delete();

        return redirect()
            ->route('page.admin.pages.index')
            ->with('success', '페이지가 삭제되었습니다.');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function pageData(array $data): array
    {
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if (($data['status'] ?? null) === 'published') {
            $data['published_at'] = now();
        } else {
            $data['published_at'] = null;
        }

        return $data;
    }
}
