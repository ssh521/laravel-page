<x-laravel-admin::admin.layouts.admin title="페이지 상세">
    @php
        $statusVariant = $page->status === 'published' ? 'success' : ($page->status === 'draft' ? 'warning' : 'neutral');
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
                    <div class="space-y-8">
                        <section>
                            <div class="mb-4">
                                <h3 class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">기본 정보</h3>
                                <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">페이지 타입, 상태, 공개 정보를 확인합니다.</p>
                            </div>
                            <dl class="grid grid-cols-1 border-t border-gray-100 sm:grid-cols-2 dark:border-gray-800">
                                <div class="px-0 py-4 sm:px-0 sm:py-5">
                                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">타입</dt>
                                    <dd class="mt-1 break-words text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ config("laravel-page.types.{$page->type}.label", $page->type) }}</dd>
                                </div>
                                <div class="border-t border-gray-100 px-0 py-4 sm:border-t-0 sm:px-0 sm:py-5 dark:border-gray-800">
                                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">공개일</dt>
                                    <dd class="mt-1 break-words text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $page->published_at?->format('Y-m-d H:i') ?: '-' }}</dd>
                                </div>
                                <div class="border-t border-gray-100 px-0 py-4 sm:px-0 sm:py-5 dark:border-gray-800">
                                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">정렬</dt>
                                    <dd class="mt-1 break-words text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $page->sort_order }}</dd>
                                </div>
                            </dl>
                        </section>

                        <section class="border-t border-gray-200 pt-6 dark:border-gray-700">
                            <div class="mb-4">
                                <h3 class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">SEO</h3>
                                <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">검색과 공유 링크에 사용하는 메타 정보입니다.</p>
                            </div>
                            <dl class="grid grid-cols-1 border-t border-gray-100 sm:grid-cols-2 dark:border-gray-800">
                                <div class="px-0 py-4 sm:px-0 sm:py-5">
                                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Meta title</dt>
                                    <dd class="mt-1 break-words text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $page->meta_title ?: '-' }}</dd>
                                </div>
                                <div class="border-t border-gray-100 px-0 py-4 sm:border-t-0 sm:px-0 sm:py-5 dark:border-gray-800">
                                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Canonical URL</dt>
                                    <dd class="mt-1 break-words text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $page->canonical_url ?: '-' }}</dd>
                                </div>
                            </dl>
                        </section>

                        <section class="border-t border-gray-200 pt-6 dark:border-gray-700">
                            <div class="mb-4">
                                <h3 class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">요약</h3>
                                <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">목록과 메타 설명에 사용할 짧은 설명입니다.</p>
                            </div>
                            <dl class="border-t border-gray-100 dark:border-gray-800">
                                <div class="px-0 py-4 sm:px-0 sm:py-5">
                                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">요약</dt>
                                    <dd class="mt-1 break-words text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $page->summary ?: '-' }}</dd>
                                </div>
                            </dl>
                        </section>
                    </div>
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
