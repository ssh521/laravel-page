@php
    $inputClass = 'mt-2 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white';
    $labelClass = 'block text-sm font-medium text-gray-900 dark:text-white';
@endphp

<div class="mx-auto grid max-w-4xl grid-cols-1 gap-x-8 text-gray-900 md:grid-cols-12 dark:text-gray-100">
    <div class="md:col-span-4">
        <h2 class="text-base font-semibold">기본 정보</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">페이지 타입, URL, 공개 상태를 설정합니다.</p>
    </div>
    <div class="mt-6 space-y-5 md:col-span-8 md:mt-0">
        <div>
            <label class="{{ $labelClass }}" for="title">제목</label>
            <input id="title" name="title" value="{{ old('title', $page->title) }}" class="{{ $inputClass }}" required>
            @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="{{ $labelClass }}" for="slug">Slug</label>
            <input id="slug" name="slug" value="{{ old('slug', $page->slug) }}" class="{{ $inputClass }}" required>
            @error('slug')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div>
                <label class="{{ $labelClass }}" for="type">타입</label>
                <select id="type" name="type" class="{{ $inputClass }}">
                    @foreach($types as $key => $type)
                        <option value="{{ $key }}" @selected(old('type', $page->type) === $key)>{{ $type['label'] ?? $key }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="{{ $labelClass }}" for="status">상태</label>
                <select id="status" name="status" class="{{ $inputClass }}">
                    @foreach($statuses as $key => $label)
                        <option value="{{ $key }}" @selected(old('status', $page->status) === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="{{ $labelClass }}" for="sort_order">정렬</label>
                <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $page->sort_order ?? 0) }}" class="{{ $inputClass }}">
            </div>
        </div>
    </div>

    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

    <div class="md:col-span-4">
        <h2 class="text-base font-semibold">본문</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">HTML 본문을 저장합니다.</p>
    </div>
    <div class="mt-6 space-y-5 md:col-span-8 md:mt-0">
        <div>
            <label class="{{ $labelClass }}" for="summary">요약</label>
            <textarea id="summary" name="summary" rows="3" class="{{ $inputClass }}">{{ old('summary', $page->summary) }}</textarea>
        </div>
        <div>
            <label class="{{ $labelClass }}" for="body">본문 HTML</label>
            <textarea id="body" name="body" rows="14" class="{{ $inputClass }}">{{ old('body', $page->body) }}</textarea>
        </div>
    </div>

    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

    <div class="md:col-span-4">
        <h2 class="text-base font-semibold">SEO</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">검색과 공유 링크에 사용할 메타 정보를 입력합니다.</p>
    </div>
    <div class="mt-6 space-y-5 md:col-span-8 md:mt-0">
        <div>
            <label class="{{ $labelClass }}" for="meta_title">Meta title</label>
            <input id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}" class="{{ $inputClass }}">
        </div>
        <div>
            <label class="{{ $labelClass }}" for="meta_description">Meta description</label>
            <textarea id="meta_description" name="meta_description" rows="3" class="{{ $inputClass }}">{{ old('meta_description', $page->meta_description) }}</textarea>
        </div>
        <div>
            <label class="{{ $labelClass }}" for="canonical_url">Canonical URL</label>
            <input id="canonical_url" name="canonical_url" value="{{ old('canonical_url', $page->canonical_url) }}" class="{{ $inputClass }}">
        </div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <label class="{{ $labelClass }}" for="og_title">OG title</label>
                <input id="og_title" name="og_title" value="{{ old('og_title', $page->og_title) }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label class="{{ $labelClass }}" for="og_image_path">OG image path</label>
                <input id="og_image_path" name="og_image_path" value="{{ old('og_image_path', $page->og_image_path) }}" class="{{ $inputClass }}">
            </div>
        </div>
        <div>
            <label class="{{ $labelClass }}" for="og_description">OG description</label>
            <textarea id="og_description" name="og_description" rows="3" class="{{ $inputClass }}">{{ old('og_description', $page->og_description) }}</textarea>
        </div>
    </div>

    <div class="mt-10 flex items-center justify-between border-t border-gray-900/10 pt-6 md:col-span-12 dark:border-white/10">
        <div>
            @if($page->exists)
                <button type="submit" form="delete-page-form" class="rounded-md border border-red-300 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">삭제</button>
            @endif
        </div>
        <div class="flex gap-2">
            <a href="{{ route('page.admin.pages.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 dark:border-gray-600 dark:text-gray-100">취소</a>
            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">저장</button>
        </div>
    </div>
</div>
