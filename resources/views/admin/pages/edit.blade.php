<x-laravel-admin::admin.layouts.admin title="페이지 정보 수정">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('page.admin.dashboard') }}">페이지 관리</a>
                - <a href="{{ route('page.admin.pages.index') }}">목록</a>
            </x-slot>
            <x-slot name="description">Edit Page</x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="px-4 py-6 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">페이지 정보 수정</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600 dark:text-gray-400">{{ $page->title }}</p>
                </div>
                <div class="mt-4 flex gap-2 sm:mt-0 sm:ml-16 sm:flex-none">
                    <a href="{{ route('page.admin.pages.show', $page) }}" class="inline-flex h-9 items-center justify-center rounded-md border border-gray-300 bg-white px-3 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                        <i class="fa-regular fa-eye mr-2 text-xs" aria-hidden="true"></i>
                        상세보기
                    </a>
                </div>
            </div>

            <x-laravel-admin::admin.session-messages />

            <form id="page-edit-form" method="post" action="{{ route('page.admin.pages.update', $page) }}" class="mt-8">
                @csrf
                @method('put')
                @include('laravel-page::admin.pages.partials.form', ['showActions' => false])
            </form>

            <form id="delete-page-form" method="post" action="{{ route('page.admin.pages.destroy', $page) }}" onsubmit="return confirm('페이지를 삭제할까요?')" class="hidden">
                @csrf
                @method('delete')
            </form>

            <div class="mx-auto mt-6 flex w-full max-w-4xl flex-col gap-3 px-2 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex justify-start">
                    <button type="submit" form="delete-page-form" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md border border-red-200 bg-white px-4 text-sm font-semibold text-red-700 shadow-sm hover:bg-red-50 dark:border-red-500/30 dark:bg-gray-900 dark:text-red-300 dark:hover:bg-red-500/10">
                        <i class="fa-regular fa-trash-can mr-2 text-xs" aria-hidden="true"></i>
                        삭제
                    </button>
                </div>

                <div class="flex flex-wrap justify-end gap-3">
                    <a href="{{ route('page.admin.pages.index') }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                        취소
                    </a>
                    <button type="submit" form="page-edit-form" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                        저장
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
