<x-laravel-admin::admin.layouts.admin title="페이지 목록">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('home') }}">HOME</a>
                - <a href="{{ route('page.admin.dashboard') }}">페이지 관리</a>
            </x-slot>
            <x-slot name="description">Page List</x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="w-full bg-white px-2 py-2 dark:bg-gray-900">
        <div class="px-4 py-6 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-start sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">페이지 목록</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">공개 페이지의 상태, 타입, SEO 정보를 관리합니다.</p>
                </div>
                <a href="{{ route('page.admin.pages.create') }}" class="mt-4 inline-flex h-10 items-center rounded-md bg-indigo-600 px-4 text-sm font-semibold !text-white shadow-sm hover:bg-indigo-500 sm:mt-0">등록하기</a>
            </div>

            @if(session('success'))
                <div class="mt-6 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif

            <form method="get" class="mt-6 flex flex-col gap-3 rounded-md border border-gray-200 bg-white p-4 sm:flex-row dark:border-gray-700 dark:bg-gray-800">
                <input name="search" value="{{ request('search') }}" placeholder="제목, slug 검색" class="h-10 rounded-md border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                <select name="type" class="h-10 rounded-md border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                    <option value="">전체 타입</option>
                    @foreach($types as $key => $type)
                        <option value="{{ $key }}" @selected(request('type') === $key)>{{ $type['label'] ?? $key }}</option>
                    @endforeach
                </select>
                <select name="status" class="h-10 rounded-md border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                    <option value="">전체 상태</option>
                    @foreach($statuses as $key => $label)
                        <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                <button class="h-10 rounded-md bg-gray-900 px-4 text-sm font-semibold text-white dark:bg-gray-100 dark:text-gray-900">검색</button>
            </form>

            <div class="mt-6 overflow-hidden rounded-md border border-gray-200 dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900 dark:text-white">페이지</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900 dark:text-white">타입</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900 dark:text-white">상태</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900 dark:text-white">공개일</th>
                            <th class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-white">관리</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-900">
                        @forelse($pages as $page)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $page->title }}</div>
                                    <div class="text-gray-500 dark:text-gray-400">/{{ config('laravel-page.prefix.web', 'pages') }}/{{ $page->slug }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $types[$page->type]['label'] ?? $page->type }}</td>
                                <td class="px-4 py-3"><span class="rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-200">{{ $statuses[$page->status] ?? $page->status }}</span></td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $page->published_at?->format('Y-m-d') ?: '-' }}</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('page.admin.pages.show', $page) }}" class="text-sm font-medium text-indigo-600">상세</a>
                                    <a href="{{ route('page.admin.pages.edit', $page) }}" class="ml-3 text-sm font-medium text-indigo-600">수정</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">등록된 페이지가 없습니다.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">{{ $pages->links() }}</div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
