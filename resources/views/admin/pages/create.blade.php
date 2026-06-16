<x-laravel-admin::admin.layouts.admin title="페이지 정보 등록">
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
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">페이지 정보 등록</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600 dark:text-gray-400">공개할 정적/반정적 페이지를 생성합니다.</p>
                </div>
                <div class="mt-4 flex gap-2 sm:mt-0 sm:ml-16 sm:flex-none">
                    <a href="{{ route('page.admin.pages.index') }}" class="inline-flex h-9 items-center justify-center rounded-md border border-gray-300 bg-white px-3 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-list mr-2 text-xs" aria-hidden="true"></i>
                        목록보기
                    </a>
                </div>
            </div>

            <form method="post" action="{{ route('page.admin.pages.store') }}" class="mt-8">
                @csrf
                @include('laravel-page::admin.pages.partials.form')
            </form>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
