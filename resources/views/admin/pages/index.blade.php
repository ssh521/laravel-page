<x-laravel-admin::admin.layouts.admin title="페이지 목록">
    @php
        $typeFilterOptions = collect($types)->mapWithKeys(fn ($type, $key) => [$key => $type['label'] ?? $key])->all();
    @endphp

    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('page.admin.dashboard') }}">페이지 관리</a>
            </x-slot>
            <x-slot name="description">Page List</x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <x-laravel-admin::admin.page-section title="페이지 목록" description="공개 페이지의 상태, 타입, SEO 정보를 관리합니다.">
            <x-slot name="actions">
                <x-laravel-admin::admin.action-button href="{{ route('page.admin.pages.create') }}" icon="plus">
                    등록하기
                </x-laravel-admin::admin.action-button>
            </x-slot>

            <x-laravel-admin::admin.session-messages />

            <x-laravel-admin::admin.filter-bar method="get">
                <x-laravel-admin::admin.filter-select
                    name="type"
                    selected="{{ request('type') }}"
                    placeholder="전체 타입"
                    :options="$typeFilterOptions"
                />
                <x-laravel-admin::admin.filter-select
                    name="status"
                    selected="{{ request('status') }}"
                    placeholder="전체 상태"
                    :options="$statuses"
                />
                <x-laravel-admin::admin.search-input name="search" value="{{ request('search') }}" placeholder="제목, slug 검색" clear-href="{{ route('page.admin.pages.index') }}" class="sm:flex-1" />
                <x-laravel-admin::admin.action-button variant="search" type="submit" icon="magnifying-glass">
                    검색
                </x-laravel-admin::admin.action-button>
            </x-laravel-admin::admin.filter-bar>

            <div class="mt-6">
                <x-laravel-admin::admin.table-shell>
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
                                            <x-laravel-admin::admin.badge :variant="$page->status === 'published' ? 'success' : ($page->status === 'draft' ? 'warning' : 'neutral')">
                                                {{ $statuses[$page->status] ?? $page->status }}
                                            </x-laravel-admin::admin.badge>
                                        </td>
                                        <td class="hidden px-3 py-4 text-sm whitespace-nowrap text-gray-600 lg:table-cell dark:text-gray-300">{{ $page->published_at?->format('Y-m-d') ?: '-' }}</td>
                                        <td class="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0">
                                            <x-laravel-admin::admin.action-button href="{{ route('page.admin.pages.show', $page) }}" variant="link" size="sm" icon="eye">
                                                상세
                                            </x-laravel-admin::admin.action-button>
                                            @if(in_array($page->type, ['terms', 'privacy', 'policy'], true))
                                                <x-laravel-admin::admin.action-button href="{{ route('page.admin.versions.index', $page) }}" variant="link" size="sm" icon="file-lines" class="ml-1">
                                                    개정 이력
                                                </x-laravel-admin::admin.action-button>
                                            @endif
                                            <x-laravel-admin::admin.action-button href="{{ route('page.admin.pages.edit', $page) }}" variant="link" size="sm" icon="pen-to-square" class="ml-1">
                                                수정
                                            </x-laravel-admin::admin.action-button>
                                        </td>
                                    </tr>
                                @empty
                                    <x-laravel-admin::admin.table-empty-row colspan="5" message="등록된 페이지가 없습니다." />
                                @endforelse
                            </tbody>
                        </table>
                </x-laravel-admin::admin.table-shell>
            </div>

            <div class="mt-6 text-sm">{{ $pages->links() }}</div>
    </x-laravel-admin::admin.page-section>
</x-laravel-admin::admin.layouts.admin>
