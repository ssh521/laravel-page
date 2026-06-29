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
        <div class="min-h-[450px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="mx-auto flex max-w-4xl flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">페이지 정보 수정</h1>
                    <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">{{ $page->title }}</p>
                </div>
                <div class="flex shrink-0">
                    <x-laravel-admin::admin.action-button href="{{ route('page.admin.pages.show', $page) }}" variant="secondary" size="sm" icon="eye">
                        상세보기
                    </x-laravel-admin::admin.action-button>
                </div>
            </div>

            <x-laravel-admin::admin.session-messages />

            <form id="page-edit-form" method="post" action="{{ route('page.admin.pages.update', $page) }}" class="mt-10">
                @csrf
                @method('put')
                @include('laravel-page::admin.pages.partials.form', ['showActions' => false])
            </form>

            <form id="delete-page-form" method="post" action="{{ route('page.admin.pages.destroy', $page) }}" onsubmit="return confirm('페이지를 삭제할까요?')" class="hidden">
                @csrf
                @method('delete')
            </form>

            <div class="mx-auto flex w-full max-w-4xl flex-row items-center justify-between gap-3 px-2">
                <div class="flex shrink-0 justify-start">
                    <x-laravel-admin::admin.action-button type="submit" form="delete-page-form" variant="danger" icon="trash-can">
                        삭제하기
                    </x-laravel-admin::admin.action-button>
                </div>

                <div class="flex shrink-0 flex-nowrap justify-end gap-3">
                    <x-laravel-admin::admin.action-button href="{{ route('page.admin.pages.index') }}" variant="secondary">
                        취소
                    </x-laravel-admin::admin.action-button>
                    <x-laravel-admin::admin.action-button type="submit" form="page-edit-form">
                        저장하기
                    </x-laravel-admin::admin.action-button>
                </div>
            </div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
