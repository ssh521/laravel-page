<x-laravel-admin::admin.layouts.admin title="페이지 상세">
    @php
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
                <a href="{{ route('page.admin.dashboard') }}">페이지 관리</a>
                - <a href="{{ route('page.admin.pages.index') }}">목록</a>
            </x-slot>
            <x-slot name="description">Page Detail</x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <x-laravel-admin::admin.page-section>
            <x-laravel-admin::admin.page-header
                :title="$page->title"
                description="/{{ config('laravel-page.prefix.web', 'pages') }}/{{ $page->slug }}"
                :breadcrumbs="[
                    ['label' => '페이지 관리', 'href' => route('page.admin.dashboard')],
                    ['label' => '페이지 목록', 'href' => route('page.admin.pages.index')],
                    ['label' => $page->title],
                ]"
            >
                <x-slot name="actions">
                    <x-laravel-admin::admin.action-button href="{{ route('page.admin.pages.index') }}" variant="secondary" icon="list">
                        목록
                    </x-laravel-admin::admin.action-button>
                </x-slot>
            </x-laravel-admin::admin.page-header>

            <x-laravel-admin::admin.card title="{{ $page->title }}" description="페이지 기본 정보와 공개 메타데이터입니다." class="mx-auto mt-8 max-w-4xl">
                <x-slot name="actions">
                    <x-laravel-admin::admin.badge :variant="$page->status === 'published' ? 'success' : ($page->status === 'draft' ? 'warning' : 'neutral')">
                        {{ config("laravel-page.statuses.{$page->status}", $page->status) }}
                    </x-laravel-admin::admin.badge>
                </x-slot>

                <x-laravel-admin::admin.key-value-grid :items="$pageDetails" />

                <x-slot name="footer">
                    <div class="flex justify-end">
                        <x-laravel-admin::admin.action-button href="{{ route('page.admin.pages.edit', $page) }}" icon="pen-to-square">
                            수정
                        </x-laravel-admin::admin.action-button>
                    </div>
                </x-slot>
            </x-laravel-admin::admin.card>

            <x-laravel-admin::admin.card title="본문 미리보기" class="mx-auto mt-8 max-w-4xl">
                <div class="prose mt-4 max-w-none dark:prose-invert">{!! $page->body !!}</div>
            </x-laravel-admin::admin.card>
    </x-laravel-admin::admin.page-section>
</x-laravel-admin::admin.layouts.admin>
