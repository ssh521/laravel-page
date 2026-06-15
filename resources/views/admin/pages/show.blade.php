<x-laravel-admin::admin.layouts.admin title="페이지 상세">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('page.admin.dashboard') }}">페이지 관리</a>
                - <a href="{{ route('page.admin.pages.index') }}">목록</a>
            </x-slot>
            <x-slot name="description">Page Detail</x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="px-4 py-6 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-start sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $page->title }}</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">/{{ config('laravel-page.prefix.web', 'pages') }}/{{ $page->slug }}</p>
                </div>
                <div class="mt-4 flex gap-2 sm:mt-0">
                    <a href="{{ route('page.admin.versions.index', $page) }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 dark:border-gray-600 dark:text-gray-100">버전</a>
                    <a href="{{ route('page.admin.pages.edit', $page) }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">수정</a>
                </div>
            </div>

            <div class="mt-8 rounded-md border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                <dl class="grid grid-cols-1 sm:grid-cols-2">
                    @foreach([
                        '타입' => config("laravel-page.types.{$page->type}.label", $page->type),
                        '상태' => config("laravel-page.statuses.{$page->status}", $page->status),
                        '공개일' => $page->published_at?->format('Y-m-d H:i') ?: '-',
                        '정렬' => $page->sort_order,
                        'Meta title' => $page->meta_title ?: '-',
                        'Canonical URL' => $page->canonical_url ?: '-',
                    ] as $label => $value)
                        <div class="border-b border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $label }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
                <div class="border-b border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">요약</dt>
                    <dd class="mt-1 whitespace-pre-line text-sm text-gray-900 dark:text-white">{{ $page->summary ?: '-' }}</dd>
                </div>
            </div>

            <div class="mt-8 rounded-md border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-800">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">본문 미리보기</h2>
                <div class="prose mt-4 max-w-none dark:prose-invert">{!! $page->body !!}</div>
            </div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
