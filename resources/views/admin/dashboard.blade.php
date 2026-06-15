<x-laravel-admin::admin.layouts.admin title="페이지 관리">
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
        <div class="px-4 py-6 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-start sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">페이지 관리</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">회사소개, 약관, 안내 페이지를 관리합니다.</p>
                </div>
                <a href="{{ route('page.admin.pages.create') }}" class="mt-4 inline-flex h-10 items-center rounded-md bg-indigo-600 px-4 text-sm font-semibold !text-white shadow-sm hover:bg-indigo-500 sm:mt-0">
                    등록하기
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach([
                    '전체' => $stats['total_pages'],
                    '공개' => $stats['published_pages'],
                    '초안' => $stats['draft_pages'],
                    '약관/정책' => $stats['terms_pages'],
                ] as $label => $value)
                    <div class="rounded-md border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $label }}</dt>
                        <dd class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $value }}</dd>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 rounded-md border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                <div class="border-b border-gray-200 px-4 py-3 dark:border-gray-700">
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white">최근 페이지</h2>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($recentPages as $page)
                        <div class="flex items-center justify-between px-4 py-3">
                            <div>
                                <a href="{{ route('page.admin.pages.edit', $page) }}" class="font-medium text-gray-900 hover:text-indigo-600 dark:text-white">{{ $page->title }}</a>
                                <p class="text-sm text-gray-500 dark:text-gray-400">/{{ config('laravel-page.prefix.web', 'pages') }}/{{ $page->slug }}</p>
                            </div>
                            <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-200">{{ config("laravel-page.statuses.{$page->status}", $page->status) }}</span>
                        </div>
                    @empty
                        <p class="px-4 py-6 text-sm text-gray-500 dark:text-gray-400">등록된 페이지가 없습니다.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
