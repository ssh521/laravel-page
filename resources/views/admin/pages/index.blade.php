<x-laravel-admin::admin.layouts.admin title="페이지 목록">
    @php
        $statusBadgeClasses = [
            'draft' => 'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/20',
            'published' => 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-500/10 dark:text-green-300 dark:ring-green-500/20',
            'hidden' => 'bg-gray-50 text-gray-700 ring-gray-500/10 dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700',
        ];
    @endphp

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
        <div class="min-h-[560px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">페이지 목록</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600 dark:text-gray-400">공개 페이지의 상태, 타입, SEO 정보를 관리합니다.</p>
                </div>
                <div class="mt-4 flex gap-2 sm:mt-0 sm:ml-16 sm:flex-none">
                    <a href="{{ route('page.admin.pages.create') }}" class="inline-flex h-9 items-center justify-center rounded-md bg-indigo-600 px-3 text-sm font-semibold !text-white shadow-sm hover:bg-indigo-500 hover:no-underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                        <i class="fa-solid fa-plus mr-2 text-xs" aria-hidden="true"></i>
                        등록하기
                    </a>
                </div>
            </div>

            <x-laravel-admin::admin.session-messages />

            <form method="get" class="mt-6 flex flex-col gap-3 rounded-lg border border-gray-200 bg-gray-50 p-4 sm:flex-row sm:flex-nowrap sm:items-center dark:border-gray-700 dark:bg-gray-800/70">
                <label for="page-type" class="sr-only">전체 타입</label>
                <select id="page-type" name="type" class="h-10 rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-900 shadow-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 sm:w-40 sm:shrink-0 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                    <option value="">전체 타입</option>
                    @foreach($types as $key => $type)
                        <option value="{{ $key }}" @selected(request('type') === $key)>{{ $type['label'] ?? $key }}</option>
                    @endforeach
                </select>
                <label for="page-status" class="sr-only">전체 상태</label>
                <select id="page-status" name="status" class="h-10 rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-900 shadow-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 sm:w-40 sm:shrink-0 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                    <option value="">전체 상태</option>
                    @foreach($statuses as $key => $label)
                        <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                <label for="page-search" class="sr-only">제목, slug 검색</label>
                <input id="page-search" name="search" value="{{ request('search') }}" placeholder="제목, slug 검색" class="h-10 min-w-0 rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 sm:flex-1 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                <button type="submit" class="inline-flex h-10 min-w-20 cursor-pointer items-center justify-center whitespace-nowrap rounded-md bg-gray-900 px-4 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900 sm:shrink-0 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200">
                    <i class="fa-solid fa-magnifying-glass mr-2 text-xs" aria-hidden="true"></i>
                    검색
                </button>
            </form>

            <div class="mt-6 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 dark:text-white">페이지</th>
                                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell dark:text-white">타입</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">상태</th>
                                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell dark:text-white">공개일</th>
                                    <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-0">
                                        <span class="sr-only">관리</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-800 dark:bg-gray-900">
                                @forelse($pages as $page)
                                    <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/80">
                                        <td class="py-4 pr-3 pl-4 text-sm sm:pl-0">
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $page->title }}</div>
                                            <a href="{{ route('laravel-page.show', $page->slug) }}" target="_blank" rel="noopener noreferrer" class="mt-1 inline-flex max-w-full items-center truncate text-gray-500 hover:!text-indigo-600 hover:no-underline dark:text-gray-400 dark:hover:!text-indigo-300">
                                                <i class="fa-solid fa-arrow-up-right-from-square mr-1.5 shrink-0 text-xs" aria-hidden="true"></i>
                                                <span class="truncate">/{{ config('laravel-page.prefix.web', 'pages') }}/{{ $page->slug }}</span>
                                            </a>
                                            <div class="mt-2 flex flex-wrap gap-1 sm:hidden">
                                                <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-gray-500/10 ring-inset dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700">{{ $types[$page->type]['label'] ?? $page->type }}</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $page->published_at?->format('Y-m-d') ?: '미공개' }}</span>
                                            </div>
                                        </td>
                                        <td class="hidden px-3 py-4 text-sm text-gray-600 sm:table-cell dark:text-gray-300">{{ $types[$page->type]['label'] ?? $page->type }}</td>
                                        <td class="px-3 py-4 text-sm whitespace-nowrap">
                                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusBadgeClasses[$page->status] ?? $statusBadgeClasses['hidden'] }}">{{ $statuses[$page->status] ?? $page->status }}</span>
                                        </td>
                                        <td class="hidden px-3 py-4 text-sm whitespace-nowrap text-gray-600 lg:table-cell dark:text-gray-300">{{ $page->published_at?->format('Y-m-d') ?: '-' }}</td>
                                        <td class="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0">
                                            <a href="{{ route('page.admin.pages.show', $page) }}" class="inline-flex items-center rounded-md px-2 py-1 text-sm font-semibold !text-indigo-600 hover:bg-indigo-50 hover:no-underline dark:!text-indigo-300 dark:hover:bg-indigo-500/10">
                                                <i class="fa-regular fa-eye mr-1.5 text-xs" aria-hidden="true"></i>
                                                상세
                                            </a>
                                            @if(in_array($page->type, ['terms', 'privacy', 'policy'], true))
                                                <a href="{{ route('page.admin.versions.index', $page) }}" class="ml-1 inline-flex items-center rounded-md px-2 py-1 text-sm font-semibold !text-indigo-600 hover:bg-indigo-50 hover:no-underline dark:!text-indigo-300 dark:hover:bg-indigo-500/10">
                                                    <i class="fa-solid fa-clock-rotate-left mr-1.5 text-xs" aria-hidden="true"></i>
                                                    개정 이력
                                                </a>
                                            @endif
                                            <a href="{{ route('page.admin.pages.edit', $page) }}" class="ml-1 inline-flex items-center rounded-md px-2 py-1 text-sm font-semibold !text-indigo-600 hover:bg-indigo-50 hover:no-underline dark:!text-indigo-300 dark:hover:bg-indigo-500/10">
                                                <i class="fa-regular fa-pen-to-square mr-1.5 text-xs" aria-hidden="true"></i>
                                                수정
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-3 py-16 text-center text-sm text-gray-500 dark:text-gray-400">등록된 페이지가 없습니다.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-6 text-sm">{{ $pages->links() }}</div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
