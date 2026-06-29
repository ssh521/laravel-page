<x-laravel-admin::admin.layouts.admin title="페이지 버전">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('page.admin.pages.show', $page) }}">{{ $page->title }}</a>
            </x-slot>
            <x-slot name="description">Page Versions</x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <x-laravel-admin::admin.page-section>
            <x-laravel-admin::admin.page-header
                title="버전 이력"
                :description="$page->title"
                :breadcrumbs="[
                    ['label' => '페이지 목록', 'href' => route('page.admin.pages.index')],
                    ['label' => $page->title, 'href' => route('page.admin.pages.show', $page)],
                    ['label' => '버전 이력'],
                ]"
            >
                <x-slot name="actions">
                    <x-laravel-admin::admin.action-button href="{{ route('page.admin.pages.show', $page) }}" variant="secondary" icon="eye">
                        상세보기
                    </x-laravel-admin::admin.action-button>
                </x-slot>
            </x-laravel-admin::admin.page-header>

            <x-laravel-admin::admin.session-messages />

            <div class="mx-auto mt-8 grid max-w-4xl grid-cols-1 gap-4 md:grid-cols-3">
                <x-laravel-admin::admin.card title="페이지 공개 상태">
                    @if($page->isPublished())
                        <x-laravel-admin::admin.badge variant="success">공개 중</x-laravel-admin::admin.badge>
                    @else
                        <x-laravel-admin::admin.badge variant="warning">공개 전</x-laravel-admin::admin.badge>
                    @endif
                </x-laravel-admin::admin.card>
                <x-laravel-admin::admin.stat
                    label="현재 공개 버전"
                    value="{{ $publishedVersion?->version_label ?: ($publishedVersion ? '버전 #'.$publishedVersion->id : '없음') }}"
                    :description="$publishedVersion?->published_at ? $publishedVersion->published_at->format('Y-m-d H:i').' 공개' : null"
                />
                <x-laravel-admin::admin.stat label="저장된 버전" value="{{ $versions->total() }}" />
            </div>

            <x-laravel-admin::admin.notice type="info" title="활용 순서" message="페이지 수정 화면에서 본문을 작성한 뒤 이 화면에서 버전 라벨과 시행일을 입력해 저장합니다. 저장된 버전의 내용을 확인한 다음 공개하면 해당 버전 본문이 실제 공개 페이지 본문으로 반영됩니다." class="mx-auto mt-6 max-w-4xl" />

            <form method="post" action="{{ route('page.admin.versions.store', $page) }}" class="mt-8">
                @csrf
                <x-laravel-admin::admin.form-section
                    title="현재 본문으로 버전 저장"
                    description="수정 화면에 저장된 현재 본문을 개정본 스냅샷으로 남깁니다."
                >
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <x-laravel-admin::admin.field name="version_label" label="버전 라벨">
                            <x-laravel-admin::admin.form-input id="version_label" name="version_label" placeholder="예: 2026년 6월 개정" class="w-full" />
                        </x-laravel-admin::admin.field>
                        <x-laravel-admin::admin.field name="effective_date" label="시행일">
                            <x-laravel-admin::admin.form-input id="effective_date" name="effective_date" type="date" class="w-full" />
                        </x-laravel-admin::admin.field>
                    </div>
                    <div class="flex justify-end">
                        <x-laravel-admin::admin.action-button type="submit" icon="file-lines">
                            버전 저장
                        </x-laravel-admin::admin.action-button>
                    </div>
                </x-laravel-admin::admin.form-section>
            </form>

            <div class="mt-8">
                <x-laravel-admin::admin.table-shell>
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <thead class="border-y border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/80">
                                <tr>
                                    <th scope="col" class="py-3 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-6 dark:text-white">버전</th>
                                    <th scope="col" class="hidden px-3 py-3 text-left text-sm font-semibold text-gray-900 sm:table-cell dark:text-white">시행일</th>
                                    <th scope="col" class="px-3 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">공개 상태</th>
                                    <th scope="col" class="hidden px-3 py-3 text-left text-sm font-semibold text-gray-900 lg:table-cell dark:text-white">현재 본문</th>
                                    <th scope="col" class="relative py-3 pr-4 pl-3 sm:pr-6">
                                        <span class="sr-only">관리</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-800 dark:bg-gray-900">
                                @forelse($versions as $version)
                                    <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/80">
                                        <td class="py-3 pr-3 pl-4 text-sm sm:pl-6">
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $version->version_label ?: '버전 #'.$version->id }}</div>
                                            <div class="mt-1 text-gray-500 sm:hidden dark:text-gray-400">시행일 {{ $version->effective_date?->format('Y-m-d') ?: '-' }}</div>
                                            <details class="mt-2">
                                                <summary class="cursor-pointer text-xs font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-300">본문 미리보기</summary>
                                                <div class="prose prose-sm mt-3 max-w-none rounded-md border border-gray-200 bg-gray-50 p-3 dark:prose-invert dark:border-gray-700 dark:bg-gray-800">
                                                    {!! $version->body ?: '<p>저장된 본문이 없습니다.</p>' !!}
                                                </div>
                                            </details>
                                        </td>
                                        <td class="hidden px-3 py-3 text-sm whitespace-nowrap text-gray-600 sm:table-cell dark:text-gray-300">{{ $version->effective_date?->format('Y-m-d') ?: '-' }}</td>
                                        <td class="px-3 py-3 text-sm whitespace-nowrap">
                                            @if($publishedVersion?->is($version))
                                                <x-laravel-admin::admin.badge variant="success">공개 중</x-laravel-admin::admin.badge>
                                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $version->published_at?->format('Y-m-d H:i') }}</p>
                                            @elseif($version->published_at)
                                                <x-laravel-admin::admin.badge>이전 공개본</x-laravel-admin::admin.badge>
                                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $version->published_at->format('Y-m-d H:i') }}</p>
                                            @else
                                                <x-laravel-admin::admin.badge variant="warning">미공개</x-laravel-admin::admin.badge>
                                            @endif
                                        </td>
                                        <td class="hidden px-3 py-3 text-sm lg:table-cell">
                                            @if($version->body === $page->body)
                                                <x-laravel-admin::admin.badge variant="success">동일</x-laravel-admin::admin.badge>
                                            @else
                                                <x-laravel-admin::admin.badge>다름</x-laravel-admin::admin.badge>
                                            @endif
                                        </td>
                                        <td class="py-3 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-6">
                                            @if(! $publishedVersion?->is($version))
                                                <form method="post" action="{{ route('page.admin.versions.publish', [$page, $version]) }}" class="inline">
                                                    @csrf
                                                    <x-laravel-admin::admin.action-button variant="link" size="sm" type="submit" icon="arrow-up">
                                                        공개
                                                    </x-laravel-admin::admin.action-button>
                                                </form>
                                            @else
                                                <span class="text-sm text-gray-400 dark:text-gray-500">공개 중</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <x-laravel-admin::admin.table-empty-row colspan="5" message="저장된 버전이 없습니다. 현재 본문으로 첫 개정본을 저장해보세요." />
                                @endforelse
                            </tbody>
                        </table>
                </x-laravel-admin::admin.table-shell>
            </div>

            <div class="mt-6 text-sm">{{ $versions->links() }}</div>
    </x-laravel-admin::admin.page-section>
</x-laravel-admin::admin.layouts.admin>
