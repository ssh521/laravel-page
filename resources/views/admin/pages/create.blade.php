<x-laravel-admin::admin.layouts.admin title="페이지 등록">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('page.admin.dashboard') }}">페이지 관리</a>
                - <a href="{{ route('page.admin.pages.index') }}">목록</a>
            </x-slot>
            <x-slot name="description">Create Page</x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">페이지 등록</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">공개할 정적/반정적 페이지를 생성합니다.</p>

            <form method="post" action="{{ route('page.admin.pages.store') }}" class="mt-8">
                @csrf
                @include('laravel-page::admin.pages.partials.form')
            </form>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
