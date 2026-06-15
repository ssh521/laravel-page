<x-laravel-admin::admin.layouts.admin title="페이지 버전">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('page.admin.pages.show', $page) }}">{{ $page->title }}</a>
            </x-slot>
            <x-slot name="description">Page Versions</x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">버전 이력</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $page->title }}</p>

            @if(session('success'))
                <div class="mt-6 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif

            <form method="post" action="{{ route('page.admin.versions.store', $page) }}" class="mt-8 rounded-md border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
                @csrf
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">현재 본문으로 버전 저장</h2>
                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <input name="version_label" placeholder="버전 라벨" class="rounded-md border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                    <input name="effective_date" type="date" class="rounded-md border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                </div>
                <div class="mt-4 text-right">
                    <button class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">버전 저장</button>
                </div>
            </form>

            <div class="mt-8 overflow-hidden rounded-md border border-gray-200 dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900 dark:text-white">라벨</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900 dark:text-white">시행일</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900 dark:text-white">공개일</th>
                            <th class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-white">관리</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-900">
                        @forelse($versions as $version)
                            <tr>
                                <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $version->version_label ?: '버전 #'.$version->id }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $version->effective_date?->format('Y-m-d') ?: '-' }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $version->published_at?->format('Y-m-d H:i') ?: '-' }}</td>
                                <td class="px-4 py-3 text-right">
                                    <form method="post" action="{{ route('page.admin.versions.publish', [$page, $version]) }}" class="inline">
                                        @csrf
                                        <button class="text-sm font-medium text-indigo-600">공개</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-8 text-center text-gray-500">저장된 버전이 없습니다.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">{{ $versions->links() }}</div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
