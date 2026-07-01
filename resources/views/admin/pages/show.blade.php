<x-laravel-admin::admin.layouts.admin title="페이지 상세">
    @php
        $statusVariant = $page->status === 'published' ? 'success' : ($page->status === 'draft' ? 'warning' : 'neutral');
        $pageDetails = [
            '타입' => config("laravel-page.types.{$page->type}.label", $page->type),
            '공개일' => $page->published_at?->format('Y-m-d H:i') ?: '-',
            '정렬' => $page->sort_order,
            'Meta title' => $page->meta_title ?: '-',
            'Canonical URL' => $page->canonical_url ?: '-',
            '요약' => $page->summary ?: '-',
        ];
    @endphp

    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">관리자 홈</a>
                - <a href="{{ route('page.admin.pages.index') }}">페이지 목록</a>
                - 상세
            </x-slot>
            <x-slot name="description">페이지 상세</x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[450px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="mx-auto max-w-4xl">
                <div class="sm:flex sm:items-start sm:justify-between">
                    <div class="sm:flex-auto">
                        <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">페이지 정보</h1>
                        <p class="mt-2 break-all text-sm leading-6 text-gray-600 dark:text-gray-400">
                            /{{ config('laravel-page.prefix.web', 'pages') }}/{{ $page->slug }}
                        </p>
                    </div>
                    <div class="mt-4 flex gap-2 sm:mt-0 sm:ml-6">
                        <x-laravel-admin::admin.action-button href="{{ route('page.admin.pages.index') }}" variant="secondary" size="sm" icon="list">
                            목록보기
                        </x-laravel-admin::admin.action-button>
                    </div>
                </div>
            </div>

            <div class="mx-auto mt-8 max-w-4xl overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="border-b border-gray-200 px-4 py-5 sm:px-6 dark:border-gray-700">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0">
                            <h2 class="truncate text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ $page->title }}</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">페이지 기본 정보와 공개 메타데이터입니다.</p>
                        </div>
                        <x-laravel-admin::admin.badge :variant="$statusVariant">
                            {{ config("laravel-page.statuses.{$page->status}", $page->status) }}
                        </x-laravel-admin::admin.badge>
                    </div>
                </div>

                <div class="px-4 py-6 sm:px-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2">
                        @foreach($pageDetails as $term => $description)
                            <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 sm:px-0 dark:border-gray-800">
                                <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ $term }}</dt>
                                <dd class="mt-1 break-words text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $description }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>

                <div class="border-t border-gray-200 px-4 py-6 sm:px-6 dark:border-gray-700">
                    <h3 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">본문 미리보기</h3>
                    <div class="prose mt-4 max-w-none dark:prose-invert">{!! $page->body !!}</div>
                </div>

                <div class="border-t border-gray-200 bg-gray-50 px-4 py-4 sm:px-6 dark:border-gray-700 dark:bg-gray-800/70">
                    <div class="flex flex-wrap justify-end gap-2">
                        <x-laravel-admin::admin.action-button href="{{ route('page.admin.pages.edit', $page) }}" icon="pen-to-square">
                            수정하기
                        </x-laravel-admin::admin.action-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
