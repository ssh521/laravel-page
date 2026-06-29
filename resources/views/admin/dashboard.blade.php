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

    <x-laravel-admin::admin.page-section
        title="페이지 관리"
        description="회사소개, 약관, 안내 페이지를 관리합니다."
    >
        <x-slot name="actions">
            <x-laravel-admin::admin.action-button href="{{ route('page.admin.pages.index') }}" variant="secondary" size="sm" icon="list">
                목록보기
            </x-laravel-admin::admin.action-button>
            <x-laravel-admin::admin.action-button href="{{ route('page.admin.pages.create') }}" size="sm" icon="plus">
                등록하기
            </x-laravel-admin::admin.action-button>
        </x-slot>

        <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
            <x-laravel-admin::admin.stat label="전체" value="{{ $stats['total_pages'] }}" />
            <x-laravel-admin::admin.stat label="공개" value="{{ $stats['published_pages'] }}" />
            <x-laravel-admin::admin.stat label="초안" value="{{ $stats['draft_pages'] }}" />
            <x-laravel-admin::admin.stat label="숨김" value="{{ $stats['hidden_pages'] }}" />
            <x-laravel-admin::admin.stat label="약관/정책" value="{{ $stats['terms_pages'] }}" />
        </div>

        <x-laravel-admin::admin.card title="최근 페이지" description="최근 수정된 페이지와 공개 상태입니다." class="mt-8">
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($recentPages as $page)
                    <div class="flex flex-col gap-3 py-4 first:pt-0 last:pb-0 sm:flex-row sm:items-center sm:justify-between">
                        <div class="min-w-0">
                            <a href="{{ route('page.admin.pages.edit', $page) }}" class="font-medium !text-gray-900 hover:!text-indigo-600 hover:no-underline dark:!text-white dark:hover:!text-indigo-300">{{ $page->title }}</a>
                            <a href="{{ route('laravel-page.show', $page->slug) }}" target="_blank" rel="noopener noreferrer" class="mt-1 inline-flex max-w-full items-center truncate text-sm text-gray-500 hover:!text-indigo-600 hover:no-underline dark:text-gray-400 dark:hover:!text-indigo-300">
                                <x-laravel-admin::admin.icon name="eye" class="mr-1.5 shrink-0 text-xs" />
                                <span class="truncate">/{{ config('laravel-page.prefix.web', 'pages') }}/{{ $page->slug }}</span>
                            </a>
                        </div>

                        @php
                            $statusVariant = match ($page->status) {
                                'published' => 'success',
                                'draft' => 'warning',
                                default => 'neutral',
                            };
                        @endphp

                        <x-laravel-admin::admin.badge :variant="$statusVariant">
                            {{ config("laravel-page.statuses.{$page->status}", $page->status) }}
                        </x-laravel-admin::admin.badge>
                    </div>
                @empty
                    <p class="py-12 text-center text-sm text-gray-500 dark:text-gray-400">등록된 페이지가 없습니다.</p>
                @endforelse
            </div>
        </x-laravel-admin::admin.card>
    </x-laravel-admin::admin.page-section>
</x-laravel-admin::admin.layouts.admin>
