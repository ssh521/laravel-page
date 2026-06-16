@php
    $inputClass = 'mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white';
    $labelClass = 'block text-sm font-medium text-gray-900 dark:text-white';
    $errorClass = 'mt-1 text-sm text-red-600 dark:text-red-400';
@endphp

<div
    class="mx-auto grid max-w-4xl grid-cols-1 gap-x-8 text-gray-900 md:grid-cols-12 dark:text-gray-100"
    x-data="{
        templates: {{ \Illuminate\Support\Js::from($templates ?? []) }},
        applyTemplate() {
            const key = this.$refs.templateSelect.value;
            const template = this.templates[key];

            if (! template) {
                return;
            }

            this.fillField('type', template.type);
            this.fillField('title', template.title);
            this.fillField('slug', template.slug);
            this.fillField('summary', template.summary);
            this.fillField('body', template.body);
            this.fillField('meta_title', template.meta_title);
            this.fillField('meta_description', template.meta_description);
            this.fillField('og_title', template.og_title || template.meta_title);
            this.fillField('og_description', template.og_description || template.meta_description);
        },
        fillField(id, value) {
            const field = document.getElementById(id);

            if (! field) {
                return;
            }

            field.value = value || '';
            field.dispatchEvent(new Event('input', { bubbles: true }));
            field.dispatchEvent(new Event('change', { bubbles: true }));
        }
    }"
>
    <div class="md:col-span-4">
        <h2 class="text-base font-semibold">기본 정보</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">페이지 타입, URL, 공개 상태를 설정합니다.</p>
    </div>
    <div class="mt-6 space-y-5 md:col-span-8 md:mt-0">
        <div>
            <label class="{{ $labelClass }}" for="template">템플릿</label>
            <div class="mt-2 flex flex-col gap-2 sm:flex-row">
                <select id="template" name="template" x-ref="templateSelect" class="block h-10 w-full rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-900 shadow-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 sm:flex-1 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                    <option value="">직접 작성</option>
                    @foreach($templates ?? [] as $key => $template)
                        <option value="{{ $key }}" @selected(old('template', $page->template) === $key)>{{ $template['label'] ?? $key }}</option>
                    @endforeach
                </select>
                <button type="button" @click="applyTemplate()" class="inline-flex h-10 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700">
                    <i class="fa-solid fa-wand-magic-sparkles mr-2 text-xs" aria-hidden="true"></i>
                    적용
                </button>
            </div>
        </div>
        <div>
            <label class="{{ $labelClass }}" for="title">제목</label>
            <input id="title" name="title" value="{{ old('title', $page->title) }}" class="{{ $inputClass }}" required>
            @error('title')<p class="{{ $errorClass }}">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="{{ $labelClass }}" for="slug">Slug</label>
            <input id="slug" name="slug" value="{{ old('slug', $page->slug) }}" class="{{ $inputClass }}" required>
            @error('slug')<p class="{{ $errorClass }}">{{ $message }}</p>@enderror
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
                <ul class="mt-2 space-y-1 text-xs text-gray-500 dark:text-gray-400">
                    <li><span class="font-semibold text-gray-700 dark:text-gray-300">초안</span>: 작성 중인 페이지입니다. 공개 이력을 비우고 방문자에게 보이지 않습니다.</li>
                    <li><span class="font-semibold text-gray-700 dark:text-gray-300">공개</span>: 방문자가 공개 URL로 볼 수 있습니다. 최초 공개 시각을 기록합니다.</li>
                    <li><span class="font-semibold text-gray-700 dark:text-gray-300">숨김</span>: 공개했던 페이지를 임시로 내립니다. 공개 이력은 유지하지만 방문자에게 보이지 않습니다.</li>
                </ul>
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
        <div
            x-data="{
                body: '',
                preview: false,
                init() {
                    this.body = this.$refs.body.value;
                },
                wrap(openTag, closeTag = '') {
                    const textarea = this.$refs.body;
                    const start = textarea.selectionStart;
                    const end = textarea.selectionEnd;
                    const selected = this.body.slice(start, end);
                    const nextValue = this.body.slice(0, start) + openTag + selected + closeTag + this.body.slice(end);

                    this.body = nextValue;
                    this.$nextTick(() => {
                        textarea.focus();
                        textarea.setSelectionRange(start + openTag.length, start + openTag.length + selected.length);
                    });
                },
                block(openTag, closeTag) {
                    const textarea = this.$refs.body;
                    const start = textarea.selectionStart;
                    const end = textarea.selectionEnd;
                    const selected = this.body.slice(start, end) || '내용';
                    const insert = openTag + selected + closeTag;

                    this.body = this.body.slice(0, start) + insert + this.body.slice(end);
                    this.$nextTick(() => {
                        textarea.focus();
                        textarea.setSelectionRange(start + openTag.length, start + openTag.length + selected.length);
                    });
                }
            }"
        >
            <label class="{{ $labelClass }}" for="body">본문 HTML</label>
            <div class="mt-2 overflow-hidden rounded-md border border-gray-300 bg-white shadow-sm dark:border-gray-600 dark:bg-gray-900">
                <div class="flex flex-wrap items-center gap-1 border-b border-gray-200 bg-gray-50 p-2 dark:border-gray-700 dark:bg-gray-800">
                    <button type="button" title="제목" @click="block('&lt;h2&gt;', '&lt;/h2&gt;')" class="inline-flex h-8 min-w-8 items-center justify-center rounded-md px-2 text-sm font-semibold text-gray-700 hover:bg-white dark:text-gray-200 dark:hover:bg-gray-700">H2</button>
                    <button type="button" title="문단" @click="block('&lt;p&gt;', '&lt;/p&gt;')" class="inline-flex h-8 min-w-8 items-center justify-center rounded-md px-2 text-sm font-semibold text-gray-700 hover:bg-white dark:text-gray-200 dark:hover:bg-gray-700">P</button>
                    <button type="button" title="굵게" @click="wrap('&lt;strong&gt;', '&lt;/strong&gt;')" class="inline-flex h-8 min-w-8 items-center justify-center rounded-md text-sm font-semibold text-gray-700 hover:bg-white dark:text-gray-200 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-bold" aria-hidden="true"></i>
                        <span class="sr-only">굵게</span>
                    </button>
                    <button type="button" title="기울임" @click="wrap('&lt;em&gt;', '&lt;/em&gt;')" class="inline-flex h-8 min-w-8 items-center justify-center rounded-md text-sm font-semibold text-gray-700 hover:bg-white dark:text-gray-200 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-italic" aria-hidden="true"></i>
                        <span class="sr-only">기울임</span>
                    </button>
                    <button type="button" title="링크" @click="wrap('&lt;a href=&quot;https://&quot;&gt;', '&lt;/a&gt;')" class="inline-flex h-8 min-w-8 items-center justify-center rounded-md text-sm font-semibold text-gray-700 hover:bg-white dark:text-gray-200 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-link" aria-hidden="true"></i>
                        <span class="sr-only">링크</span>
                    </button>
                    <button type="button" title="목록" @click="block('&lt;ul&gt;\n    &lt;li&gt;', '&lt;/li&gt;\n&lt;/ul&gt;')" class="inline-flex h-8 min-w-8 items-center justify-center rounded-md text-sm font-semibold text-gray-700 hover:bg-white dark:text-gray-200 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-list-ul" aria-hidden="true"></i>
                        <span class="sr-only">목록</span>
                    </button>
                    <button type="button" title="인용" @click="block('&lt;blockquote&gt;', '&lt;/blockquote&gt;')" class="inline-flex h-8 min-w-8 items-center justify-center rounded-md text-sm font-semibold text-gray-700 hover:bg-white dark:text-gray-200 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-quote-right" aria-hidden="true"></i>
                        <span class="sr-only">인용</span>
                    </button>
                    <button type="button" title="코드" @click="wrap('&lt;code&gt;', '&lt;/code&gt;')" class="inline-flex h-8 min-w-8 items-center justify-center rounded-md text-sm font-semibold text-gray-700 hover:bg-white dark:text-gray-200 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-code" aria-hidden="true"></i>
                        <span class="sr-only">코드</span>
                    </button>
                    <div class="ml-auto">
                        <button type="button" @click="preview = ! preview" class="inline-flex h-8 items-center justify-center whitespace-nowrap rounded-md border border-gray-300 bg-white px-3 text-xs font-semibold text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-700">
                            <i class="fa-regular fa-eye mr-1.5" aria-hidden="true"></i>
                            <span x-text="preview ? '편집' : '미리보기'"></span>
                        </button>
                    </div>
                </div>
                <textarea x-show="! preview" x-ref="body" x-model="body" id="body" name="body" rows="14" class="block w-full resize-y border-0 bg-white px-3 py-2 text-sm text-gray-900 outline-none placeholder:text-gray-400 focus:ring-0 dark:bg-gray-900 dark:text-white">{{ old('body', $page->body) }}</textarea>
                <div x-show="preview" x-cloak class="min-h-80 bg-white px-4 py-4 dark:bg-gray-900">
                    <div class="prose max-w-none dark:prose-invert" x-html="body"></div>
                </div>
            </div>
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

    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

    @if($showActions ?? true)
        <div class="col-span-full flex items-center justify-end gap-x-3">
            <a href="{{ route('page.admin.pages.index') }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                취소
            </a>
            <button type="submit" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                저장
            </button>
        </div>
    @endif
</div>
