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
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">버전 이력</h1>
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

            <div class="mx-auto mt-8 grid max-w-4xl grid-cols-1 gap-4 md:grid-cols-3">
                <dl class="rounded-md border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">페이지 공개 상태</dt>
                    <dd class="mt-2">
                        @if($page->isPublished())
                            <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset dark:bg-green-500/10 dark:text-green-300 dark:ring-green-500/20">공개 중</span>
                        @else
                            <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-amber-600/20 ring-inset dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/20">공개 전</span>
                        @endif
                    </dd>
                </dl>
                <dl class="rounded-md border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">현재 공개 버전</dt>
                    <dd class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">
                        {{ $publishedVersion?->version_label ?: ($publishedVersion ? '버전 #'.$publishedVersion->id : '없음') }}
                    </dd>
                    @if($publishedVersion?->published_at)
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $publishedVersion->published_at->format('Y-m-d H:i') }} 공개</p>
                    @endif
                </dl>
                <dl class="rounded-md border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">저장된 버전</dt>
                    <dd class="mt-2 text-2xl font-semibold text-gray-900 dark:text-white">{{ $versions->total() }}</dd>
                </dl>
            </div>

            <div class="mx-auto mt-6 max-w-4xl rounded-md border border-indigo-200 bg-indigo-50 p-4 text-sm text-indigo-900 dark:border-indigo-500/30 dark:bg-indigo-500/10 dark:text-indigo-200">
                <p class="font-semibold">활용 순서</p>
                <p class="mt-1">페이지 수정 화면에서 본문을 작성한 뒤 이 화면에서 버전 라벨과 시행일을 입력해 저장합니다. 저장된 버전의 내용을 확인한 다음 공개하면 해당 버전 본문이 실제 공개 페이지 본문으로 반영됩니다.</p>
            </div>

            <form method="post" action="{{ route('page.admin.versions.store', $page) }}" class="mx-auto mt-8 grid max-w-4xl grid-cols-1 gap-x-8 rounded-md border border-gray-200 bg-white p-6 text-gray-900 shadow-sm md:grid-cols-12 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                @csrf
                <div class="md:col-span-4">
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white">현재 본문으로 버전 저장</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">수정 화면에 저장된 현재 본문을 개정본 스냅샷으로 남깁니다.</p>
                </div>
                <div class="mt-6 space-y-4 md:col-span-8 md:mt-0">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="version-label" class="block text-sm font-medium text-gray-900 dark:text-white">버전 라벨</label>
                            <input id="version-label" name="version_label" placeholder="예: 2026년 6월 개정" class="mt-2 block h-10 w-full rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label for="effective-date" class="block text-sm font-medium text-gray-900 dark:text-white">시행일</label>
                            <input id="effective-date" name="effective_date" type="date" class="mt-2 block h-10 w-full rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-900 shadow-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                            <i class="fa-regular fa-floppy-disk mr-2 text-xs" aria-hidden="true"></i>
                            버전 저장
                        </button>
                    </div>
                </div>
            </form>

            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 dark:text-white">버전</th>
                                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell dark:text-white">시행일</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">공개 상태</th>
                                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell dark:text-white">현재 본문</th>
                                    <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-0">
                                        <span class="sr-only">관리</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-800 dark:bg-gray-900">
                                @forelse($versions as $version)
                                    <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/80">
                                        <td class="py-4 pr-3 pl-4 text-sm sm:pl-0">
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $version->version_label ?: '버전 #'.$version->id }}</div>
                                            <div class="mt-1 text-gray-500 sm:hidden dark:text-gray-400">시행일 {{ $version->effective_date?->format('Y-m-d') ?: '-' }}</div>
                                            <details class="mt-2">
                                                <summary class="cursor-pointer text-xs font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-300">본문 미리보기</summary>
                                                <div class="prose prose-sm mt-3 max-w-none rounded-md border border-gray-200 bg-gray-50 p-3 dark:prose-invert dark:border-gray-700 dark:bg-gray-800">
                                                    {!! $version->body ?: '<p>저장된 본문이 없습니다.</p>' !!}
                                                </div>
                                            </details>
                                        </td>
                                        <td class="hidden px-3 py-4 text-sm whitespace-nowrap text-gray-600 sm:table-cell dark:text-gray-300">{{ $version->effective_date?->format('Y-m-d') ?: '-' }}</td>
                                        <td class="px-3 py-4 text-sm whitespace-nowrap">
                                            @if($publishedVersion?->is($version))
                                                <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset dark:bg-green-500/10 dark:text-green-300 dark:ring-green-500/20">공개 중</span>
                                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $version->published_at?->format('Y-m-d H:i') }}</p>
                                            @elseif($version->published_at)
                                                <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-gray-500/10 ring-inset dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700">이전 공개본</span>
                                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $version->published_at->format('Y-m-d H:i') }}</p>
                                            @else
                                                <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-amber-600/20 ring-inset dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/20">미공개</span>
                                            @endif
                                        </td>
                                        <td class="hidden px-3 py-4 text-sm lg:table-cell">
                                            @if($version->body === $page->body)
                                                <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset dark:bg-green-500/10 dark:text-green-300 dark:ring-green-500/20">동일</span>
                                            @else
                                                <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-gray-500/10 ring-inset dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700">다름</span>
                                            @endif
                                        </td>
                                        <td class="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0">
                                            @if(! $publishedVersion?->is($version))
                                                <form method="post" action="{{ route('page.admin.versions.publish', [$page, $version]) }}" class="inline">
                                                    @csrf
                                                    <button class="inline-flex items-center rounded-md px-2 py-1 text-sm font-semibold !text-indigo-600 hover:bg-indigo-50 hover:no-underline dark:!text-indigo-300 dark:hover:bg-indigo-500/10">
                                                        <i class="fa-solid fa-upload mr-1.5 text-xs" aria-hidden="true"></i>
                                                        공개
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-sm text-gray-400 dark:text-gray-500">공개 중</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-3 py-16 text-center text-sm text-gray-500 dark:text-gray-400">저장된 버전이 없습니다. 현재 본문으로 첫 개정본을 저장해보세요.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-6 text-sm">{{ $versions->links() }}</div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
