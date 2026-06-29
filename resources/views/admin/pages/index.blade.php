<x-laravel-admin::admin.layouts.admin title="페이지 목록">
    @php
        $typeFilterOptions = collect($types)->mapWithKeys(fn ($type, $key) => [$key => $type['label'] ?? $key])->all();
        $currentSortField = request('sortField', 'sort_order');
        $currentSortDirection = request('sortDirection', 'asc') === 'desc' ? 'desc' : 'asc';
        $getNextSortDirection = fn (string $field): string => $currentSortField === $field && $currentSortDirection === 'asc' ? 'desc' : 'asc';
        $sortLinkClass = 'inline-flex items-center justify-center gap-1 !text-gray-900 hover:!text-indigo-600 hover:no-underline dark:!text-white dark:hover:!text-indigo-400';
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

            <x-laravel-admin::admin.filter-bar action="{{ route('page.admin.pages.index') }}">
                @if(request('sortField'))
                    <input type="hidden" name="sortField" value="{{ request('sortField') }}">
                @endif
                @if(request('sortDirection'))
                    <input type="hidden" name="sortDirection" value="{{ request('sortDirection') }}">
                @endif

                <label for="page-type-filter" class="sr-only">전체 타입</label>
                <div class="w-full shrink-0 sm:w-40">
                    <x-laravel-admin::admin.form-select id="page-type-filter" name="type" class="h-10">
                        <option value="">전체 타입</option>
                        @foreach($typeFilterOptions as $value => $label)
                            <option value="{{ $value }}" @selected(request('type') === (string) $value)>{{ $label }}</option>
                        @endforeach
                    </x-laravel-admin::admin.form-select>
                </div>

                <label for="page-status-filter" class="sr-only">전체 상태</label>
                <div class="w-full shrink-0 sm:w-40">
                    <x-laravel-admin::admin.form-select id="page-status-filter" name="status" class="h-10">
                        <option value="">전체 상태</option>
                        @foreach($statuses as $value => $label)
                            <option value="{{ $value }}" @selected(request('status') === (string) $value)>{{ $label }}</option>
                        @endforeach
                    </x-laravel-admin::admin.form-select>
                </div>

                <label for="page-search" class="sr-only">페이지 검색</label>
                <div class="relative min-w-0 flex-1">
                    <x-laravel-admin::admin.form-input
                        id="page-search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="제목, slug 검색"
                        class="h-10 w-full pr-9"
                    />
                    @if(request('search') || request('type') || request('status'))
                        <a href="{{ route('page.admin.pages.index') }}"
                           class="absolute right-3 top-1/2 -translate-y-1/2 !text-gray-400 hover:!text-gray-600 hover:no-underline dark:hover:!text-gray-300">
                            <x-laravel-admin::admin.icon name="xmark" class="text-sm" />
                        </a>
                    @endif
                </div>

                <x-laravel-admin::admin.action-button variant="search" type="submit" icon="magnifying-glass" class="w-full shrink-0 whitespace-nowrap sm:w-auto">
                    검색
                </x-laravel-admin::admin.action-button>
            </x-laravel-admin::admin.filter-bar>

            <div class="mt-6">
                <x-laravel-admin::admin.table-shell>
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <thead class="border-y border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/80">
                                <tr>
                                    <th scope="col" class="py-3 pr-3 pl-4 text-center text-sm font-semibold text-gray-900 sm:pl-0 dark:text-white">
                                        <a href="{{ route('page.admin.pages.index', array_merge(request()->query(), ['sortField' => 'title', 'sortDirection' => $getNextSortDirection('title')])) }}" class="{{ $sortLinkClass }}">
                                            <span>페이지</span>
                                            @if($currentSortField === 'title')
                                                <x-laravel-admin::admin.icon name="{{ $currentSortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}" class="text-xs" />
                                            @else
                                                <x-laravel-admin::admin.icon name="sort" class="text-xs text-gray-400" />
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="hidden px-3 py-3 text-center text-sm font-semibold text-gray-900 md:table-cell dark:text-white">링크</th>
                                    <th scope="col" class="hidden px-3 py-3 text-center text-sm font-semibold text-gray-900 sm:table-cell dark:text-white">
                                        <a href="{{ route('page.admin.pages.index', array_merge(request()->query(), ['sortField' => 'type', 'sortDirection' => $getNextSortDirection('type')])) }}" class="{{ $sortLinkClass }}">
                                            <span>타입</span>
                                            @if($currentSortField === 'type')
                                                <x-laravel-admin::admin.icon name="{{ $currentSortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}" class="text-xs" />
                                            @else
                                                <x-laravel-admin::admin.icon name="sort" class="text-xs text-gray-400" />
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-center text-sm font-semibold text-gray-900 dark:text-white">
                                        <a href="{{ route('page.admin.pages.index', array_merge(request()->query(), ['sortField' => 'status', 'sortDirection' => $getNextSortDirection('status')])) }}" class="{{ $sortLinkClass }}">
                                            <span>상태</span>
                                            @if($currentSortField === 'status')
                                                <x-laravel-admin::admin.icon name="{{ $currentSortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}" class="text-xs" />
                                            @else
                                                <x-laravel-admin::admin.icon name="sort" class="text-xs text-gray-400" />
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="hidden px-3 py-3 text-center text-sm font-semibold text-gray-900 lg:table-cell dark:text-white">
                                        <a href="{{ route('page.admin.pages.index', array_merge(request()->query(), ['sortField' => 'published_at', 'sortDirection' => $getNextSortDirection('published_at')])) }}" class="{{ $sortLinkClass }}">
                                            <span>공개일</span>
                                            @if($currentSortField === 'published_at')
                                                <x-laravel-admin::admin.icon name="{{ $currentSortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}" class="text-xs" />
                                            @else
                                                <x-laravel-admin::admin.icon name="sort" class="text-xs text-gray-400" />
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="relative py-3 pr-4 pl-3 sm:pr-0">
                                        <span class="sr-only">관리</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-800 dark:bg-gray-900">
                                @forelse($pages as $page)
                                    <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/80">
                                        <td class="py-3 pr-3 pl-4 text-sm sm:pl-0">
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $page->title }}</div>
                                            <a href="{{ route('laravel-page.show', $page->slug) }}" target="_blank" rel="noopener noreferrer" class="mt-1 inline-flex max-w-full items-center truncate text-xs text-gray-500 hover:!text-indigo-600 hover:no-underline md:hidden dark:text-gray-400 dark:hover:!text-indigo-300">
                                                <span class="truncate">/{{ config('laravel-page.prefix.web', 'pages') }}/{{ $page->slug }}</span>
                                            </a>
                                            <div class="mt-2 flex flex-wrap gap-1 sm:hidden">
                                                <x-laravel-admin::admin.badge>{{ $types[$page->type]['label'] ?? $page->type }}</x-laravel-admin::admin.badge>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $page->published_at?->format('Y-m-d') ?: '미공개' }}</span>
                                            </div>
                                        </td>
                                        <td class="hidden max-w-xs px-3 py-3 text-center text-sm md:table-cell">
                                            <a href="{{ route('laravel-page.show', $page->slug) }}" target="_blank" rel="noopener noreferrer" class="inline-flex max-w-full items-center justify-center truncate text-gray-600 hover:!text-indigo-600 hover:no-underline dark:text-gray-300 dark:hover:!text-indigo-300">
                                                <x-laravel-admin::admin.icon name="eye" class="mr-1.5 shrink-0 text-xs" />
                                                <span class="truncate">/{{ config('laravel-page.prefix.web', 'pages') }}/{{ $page->slug }}</span>
                                            </a>
                                        </td>
                                        <td class="hidden px-3 py-3 text-center text-sm text-gray-600 sm:table-cell dark:text-gray-300">{{ $types[$page->type]['label'] ?? $page->type }}</td>
                                        <td class="px-3 py-3 text-center text-sm whitespace-nowrap">
                                            <x-laravel-admin::admin.badge :variant="$page->status === 'published' ? 'success' : ($page->status === 'draft' ? 'warning' : 'neutral')">
                                                {{ $statuses[$page->status] ?? $page->status }}
                                            </x-laravel-admin::admin.badge>
                                        </td>
                                        <td class="hidden px-3 py-3 text-center text-sm whitespace-nowrap text-gray-600 lg:table-cell dark:text-gray-300">{{ $page->published_at?->format('Y-m-d') ?: '-' }}</td>
                                        <td class="py-3 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0">
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
                                    <x-laravel-admin::admin.table-empty-row colspan="6" message="등록된 페이지가 없습니다." />
                                @endforelse
                            </tbody>
                        </table>
                </x-laravel-admin::admin.table-shell>
            </div>

            <div class="mt-6 text-sm">{{ $pages->links() }}</div>
    </x-laravel-admin::admin.page-section>
</x-laravel-admin::admin.layouts.admin>
