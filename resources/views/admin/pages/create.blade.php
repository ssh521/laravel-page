<x-laravel-admin::admin.layouts.admin title="페이지 정보 등록">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">관리자 홈</a>
                - <a href="{{ route('page.admin.pages.index') }}">페이지 목록</a>
                - 등록
            </x-slot>
            <x-slot name="description">Create Page</x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[450px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="mx-auto flex max-w-4xl flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">페이지 정보 등록</h1>
                    <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">공개할 정적/반정적 페이지를 생성합니다.</p>
                </div>
                <div class="flex shrink-0">
                    <x-laravel-admin::admin.action-button href="{{ route('page.admin.pages.index') }}" variant="secondary" size="sm" icon="list">
                        목록
                    </x-laravel-admin::admin.action-button>
                </div>
            </div>

            <form method="post" action="{{ route('page.admin.pages.store') }}" class="mt-10">
                @csrf
                @include('laravel-page::admin.pages.partials.form')
            </form>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
