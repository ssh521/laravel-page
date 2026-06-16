<x-laravel-admin::admin.layouts.admin title="페이지 상세">
    @php
        $statusBadgeClasses = [
            'draft' => 'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/20',
            'published' => 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-500/10 dark:text-green-300 dark:ring-green-500/20',
            'hidden' => 'bg-gray-50 text-gray-700 ring-gray-500/10 dark:bg-gray-900 dark:text-gray-300 dark:ring-gray-700',
        ];
    @endphp

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
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ $page->title }}</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600 dark:text-gray-400">/{{ config('laravel-page.prefix.web', 'pages') }}/{{ $page->slug }}</p>
                </div>
                <div class="mt-4 flex gap-2 sm:mt-0 sm:ml-16 sm:flex-none">
                    <a href="{{ route('page.admin.pages.index') }}" class="inline-flex h-9 items-center justify-center rounded-md border border-gray-300 bg-white px-3 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-list mr-2 text-xs" aria-hidden="true"></i>
                        목록
                    </a>
                </div>
            </div>

            <div class="mx-auto mt-8 max-w-4xl overflow-hidden rounded-md border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="border-b border-gray-200 px-4 py-5 sm:px-6 dark:border-gray-700">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ $page->title }}</h2>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">페이지 기본 정보와 공개 메타데이터입니다.</p>
                        </div>
                        <span class="inline-flex w-fit items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusBadgeClasses[$page->status] ?? $statusBadgeClasses['hidden'] }}">{{ config("laravel-page.statuses.{$page->status}", $page->status) }}</span>
                    </div>
                </div>
                <dl class="grid grid-cols-1 sm:grid-cols-2">
                    @foreach([
                        '타입' => config("laravel-page.types.{$page->type}.label", $page->type),
                        '공개일' => $page->published_at?->format('Y-m-d H:i') ?: '-',
                        '정렬' => $page->sort_order,
                        'Meta title' => $page->meta_title ?: '-',
                        'Canonical URL' => $page->canonical_url ?: '-',
                    ] as $label => $value)
                        <div class="border-b border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $label }}</dt>
                            <dd class="mt-1 break-words text-sm text-gray-900 dark:text-white">{{ $value }}</dd>
                        </div>
                    @endforeach
                    <div class="border-b border-gray-200 px-4 py-4 sm:col-span-2 sm:px-6 dark:border-gray-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">요약</dt>
                        <dd class="mt-1 whitespace-pre-line text-sm text-gray-900 dark:text-white">{{ $page->summary ?: '-' }}</dd>
                    </div>
                </dl>
                <div class="flex justify-end px-4 py-4 sm:px-6">
                    <a href="{{ route('page.admin.pages.edit', $page) }}" class="inline-flex h-10 items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold !text-white shadow-sm hover:bg-indigo-500 hover:no-underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400">수정</a>
                </div>
            </div>

            <div class="mx-auto mt-8 max-w-4xl rounded-md border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">본문 미리보기</h2>
                <div class="prose mt-4 max-w-none dark:prose-invert">{!! $page->body !!}</div>
            </div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
