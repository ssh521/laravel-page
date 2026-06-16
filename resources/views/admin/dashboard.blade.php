<x-laravel-admin::admin.layouts.admin title="페이지 관리">
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
                <a href="{{ route('home') }}">HOME</a>
                - <a href="{{ route('admin.index') }}">관리자 홈</a>
            </x-slot>
            <x-slot name="description">Page CMS</x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="w-full bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[560px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">페이지 관리</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600 dark:text-gray-400">회사소개, 약관, 안내 페이지를 관리합니다.</p>
                </div>
                <div class="mt-4 flex gap-2 sm:mt-0 sm:ml-16 sm:flex-none">
                    <a href="{{ route('page.admin.pages.index') }}" class="inline-flex h-9 items-center justify-center rounded-md border border-gray-300 bg-white px-3 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-list mr-2 text-xs" aria-hidden="true"></i>
                        목록보기
                    </a>
                    <a href="{{ route('page.admin.pages.create') }}" class="inline-flex h-9 items-center justify-center rounded-md bg-indigo-600 px-3 text-sm font-semibold !text-white shadow-sm hover:bg-indigo-500 hover:no-underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                        <i class="fa-solid fa-plus mr-2 text-xs" aria-hidden="true"></i>
                        등록하기
                    </a>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
                @foreach([
                    '전체' => $stats['total_pages'],
                    '공개' => $stats['published_pages'],
                    '초안' => $stats['draft_pages'],
                    '숨김' => $stats['hidden_pages'],
                    '약관/정책' => $stats['terms_pages'],
                ] as $label => $value)
                    <div class="rounded-md border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $label }}</dt>
                        <dd class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $value }}</dd>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 overflow-hidden rounded-md border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="border-b border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700">
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white">최근 페이지</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">최근 수정된 페이지와 공개 상태입니다.</p>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($recentPages as $page)
                        <div class="flex flex-col gap-3 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                            <div class="min-w-0">
                                <a href="{{ route('page.admin.pages.edit', $page) }}" class="font-medium !text-gray-900 hover:!text-indigo-600 hover:no-underline dark:!text-white dark:hover:!text-indigo-300">{{ $page->title }}</a>
                                <a href="{{ route('laravel-page.show', $page->slug) }}" target="_blank" rel="noopener noreferrer" class="mt-1 inline-flex max-w-full items-center truncate text-sm text-gray-500 hover:!text-indigo-600 hover:no-underline dark:text-gray-400 dark:hover:!text-indigo-300">
                                    <i class="fa-solid fa-arrow-up-right-from-square mr-1.5 shrink-0 text-xs" aria-hidden="true"></i>
                                    <span class="truncate">/{{ config('laravel-page.prefix.web', 'pages') }}/{{ $page->slug }}</span>
                                </a>
                            </div>
                            <span class="inline-flex w-fit items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusBadgeClasses[$page->status] ?? $statusBadgeClasses['hidden'] }}">{{ config("laravel-page.statuses.{$page->status}", $page->status) }}</span>
                        </div>
                    @empty
                        <p class="px-4 py-12 text-center text-sm text-gray-500 dark:text-gray-400">등록된 페이지가 없습니다.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
