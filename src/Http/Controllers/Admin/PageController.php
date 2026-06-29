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
        $sortableFields = [
            'title' => 'title',
            'type' => 'type',
            'status' => 'status',
            'published_at' => 'published_at',
            'sort_order' => 'sort_order',
            'created_at' => 'created_at',
        ];
        $sortField = array_key_exists($request->string('sortField')->toString(), $sortableFields)
            ? $request->string('sortField')->toString()
            : 'sort_order';
        $sortDirection = $request->string('sortDirection')->toString() === 'desc' ? 'desc' : 'asc';

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
            ->orderBy($sortableFields[$sortField], $sortDirection)
            ->orderByDesc('created_at')
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
        $templates = config('laravel-page.templates', []);

        return view('laravel-page::admin.pages.create', [
            'page' => new Page(['type' => 'page', 'status' => 'draft']),
            'types' => config('laravel-page.types', []),
            'statuses' => config('laravel-page.statuses', []),
            'templates' => $templates,
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
            'templates' => config('laravel-page.templates', []),
        ]);
    }

    public function update(UpdatePageRequest $request, Page $page): RedirectResponse
    {
        $page->update($this->pageData($request->validated(), $page));

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
    private function pageData(array $data, ?Page $page = null): array
    {
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $status = $data['status'] ?? null;

        if ($status === 'published') {
            $data['published_at'] = $page?->published_at ?: now();
        } elseif ($status === 'hidden') {
            $data['published_at'] = $page?->published_at;
        } else {
            $data['published_at'] = null;
        }

        return $data;
    }
}
