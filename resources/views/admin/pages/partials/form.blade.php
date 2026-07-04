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
        <div class="flex flex-col">
            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">기본 정보</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">페이지 타입, URL, 공개 상태를 설정합니다.</p>
        </div>
    </div>

    <div class="mt-6 md:col-span-8 md:mt-0">
        <div class="space-y-5">
            <x-laravel-admin::admin.field name="template" label="템플릿">
                <div class="flex flex-col gap-2 sm:flex-row">
                    <x-laravel-admin::admin.form-select id="template" name="template" x-ref="templateSelect" class="h-10 sm:flex-1">
                        <option value="">직접 작성</option>
                        @foreach($templates ?? [] as $key => $template)
                            <option value="{{ $key }}" @selected(old('template', $page->template) === $key)>{{ $template['label'] ?? $key }}</option>
                        @endforeach
                    </x-laravel-admin::admin.form-select>
                    <x-laravel-admin::admin.action-button type="button" variant="secondary" @click="applyTemplate()" class="h-10 shrink-0">
                        적용
                    </x-laravel-admin::admin.action-button>
                </div>
            </x-laravel-admin::admin.field>

            <x-laravel-admin::admin.field name="title" label="제목" required>
                <x-laravel-admin::admin.form-input id="title" name="title" value="{{ old('title', $page->title) }}" class="w-full" required />
            </x-laravel-admin::admin.field>

            <x-laravel-admin::admin.field name="slug" label="Slug" required>
                <x-laravel-admin::admin.form-input id="slug" name="slug" value="{{ old('slug', $page->slug) }}" class="w-full" required />
            </x-laravel-admin::admin.field>

            <x-laravel-admin::admin.field name="status" label="상태">
                <div class="max-w-sm">
                    <x-laravel-admin::admin.form-select id="status" name="status">
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" @selected(old('status', $page->status) === $key)>{{ $label }}</option>
                        @endforeach
                    </x-laravel-admin::admin.form-select>
                </div>
                <ul class="mt-2 space-y-1 text-xs text-gray-500 dark:text-gray-400">
                    <li><span class="font-semibold text-gray-700 dark:text-gray-300">초안</span>: 작성 중인 페이지입니다.</li>
                    <li><span class="font-semibold text-gray-700 dark:text-gray-300">공개</span>: 방문자가 공개 URL로 볼 수 있습니다.</li>
                    <li><span class="font-semibold text-gray-700 dark:text-gray-300">숨김</span>: 공개했던 페이지를 임시로 내립니다.</li>
                </ul>
            </x-laravel-admin::admin.field>

            <div class="space-y-5">
                <x-laravel-admin::admin.field name="type" label="타입">
                    <div class="max-w-sm">
                        <x-laravel-admin::admin.form-select id="type" name="type">
                            @foreach($types as $key => $type)
                                <option value="{{ $key }}" @selected(old('type', $page->type) === $key)>{{ $type['label'] ?? $key }}</option>
                            @endforeach
                        </x-laravel-admin::admin.form-select>
                    </div>
                </x-laravel-admin::admin.field>

                <x-laravel-admin::admin.field name="sort_order" label="정렬">
                    <x-laravel-admin::admin.form-input
                        id="sort_order"
                        name="sort_order"
                        type="number"
                        min="0"
                        value="{{ old('sort_order', $page->sort_order ?? 0) }}"
                        class="w-16"
                    />
                </x-laravel-admin::admin.field>
            </div>
        </div>
    </div>

    <div class="md:col-span-12 dark:border-white/10 mt-8 mb-6 border-b border-gray-900/10 sm:my-10"></div>

    <div class="md:col-span-4">
        <div class="flex flex-col">
            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">본문</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">HTML 본문을 저장합니다.</p>
        </div>
    </div>

    <div class="mt-6 md:col-span-8 md:mt-0">
        <div class="space-y-5">
            <x-laravel-admin::admin.field name="summary" label="요약">
                <x-laravel-admin::admin.form-textarea id="summary" name="summary" rows="3">{{ old('summary', $page->summary) }}</x-laravel-admin::admin.form-textarea>
            </x-laravel-admin::admin.field>

            <x-laravel-admin::admin.field name="body" label="본문 HTML">
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
                    class="overflow-hidden rounded-md border border-gray-300 bg-white shadow-sm dark:border-gray-600 dark:bg-gray-900"
                >
                    <div class="flex flex-wrap items-center gap-1 border-b border-gray-200 bg-gray-50 p-2 dark:border-gray-700 dark:bg-gray-800">
                        <button type="button" title="제목" @click="block('&lt;h2&gt;', '&lt;/h2&gt;')" class="inline-flex h-8 min-w-8 items-center justify-center rounded-md px-2 text-sm font-semibold text-gray-700 hover:bg-white dark:text-gray-200 dark:hover:bg-gray-700">H2</button>
                        <button type="button" title="문단" @click="block('&lt;p&gt;', '&lt;/p&gt;')" class="inline-flex h-8 min-w-8 items-center justify-center rounded-md px-2 text-sm font-semibold text-gray-700 hover:bg-white dark:text-gray-200 dark:hover:bg-gray-700">P</button>
                        <button type="button" title="굵게" @click="wrap('&lt;strong&gt;', '&lt;/strong&gt;')" class="inline-flex h-8 min-w-8 items-center justify-center rounded-md px-2 text-sm font-semibold text-gray-700 hover:bg-white dark:text-gray-200 dark:hover:bg-gray-700">B</button>
                        <button type="button" title="기울임" @click="wrap('&lt;em&gt;', '&lt;/em&gt;')" class="inline-flex h-8 min-w-8 items-center justify-center rounded-md px-2 text-sm font-semibold text-gray-700 hover:bg-white dark:text-gray-200 dark:hover:bg-gray-700">I</button>
                        <button type="button" title="링크" @click="wrap('&lt;a href=&quot;https://&quot;&gt;', '&lt;/a&gt;')" class="inline-flex h-8 min-w-8 items-center justify-center rounded-md px-2 text-sm font-semibold text-gray-700 hover:bg-white dark:text-gray-200 dark:hover:bg-gray-700">Link</button>
                        <button type="button" title="목록" @click="block('&lt;ul&gt;\n    &lt;li&gt;', '&lt;/li&gt;\n&lt;/ul&gt;')" class="inline-flex h-8 min-w-8 items-center justify-center rounded-md px-2 text-sm font-semibold text-gray-700 hover:bg-white dark:text-gray-200 dark:hover:bg-gray-700">List</button>
                        <button type="button" title="인용" @click="block('&lt;blockquote&gt;', '&lt;/blockquote&gt;')" class="inline-flex h-8 min-w-8 items-center justify-center rounded-md px-2 text-sm font-semibold text-gray-700 hover:bg-white dark:text-gray-200 dark:hover:bg-gray-700">Quote</button>
                        <button type="button" title="코드" @click="wrap('&lt;code&gt;', '&lt;/code&gt;')" class="inline-flex h-8 min-w-8 items-center justify-center rounded-md px-2 text-sm font-semibold text-gray-700 hover:bg-white dark:text-gray-200 dark:hover:bg-gray-700">Code</button>
                        <div class="ml-auto">
                            <x-laravel-admin::admin.action-button type="button" variant="secondary" size="sm" @click="preview = ! preview">
                                <span x-text="preview ? '편집' : '미리보기'"></span>
                            </x-laravel-admin::admin.action-button>
                        </div>
                    </div>
                    <textarea x-show="! preview" x-ref="body" x-model="body" id="body" name="body" rows="14" class="block w-full resize-y border-0 bg-white px-3 py-2 text-sm text-gray-900 outline-none placeholder:text-gray-400 focus:ring-0 dark:bg-gray-900 dark:text-white">{{ old('body', $page->body) }}</textarea>
                    <div x-show="preview" x-cloak class="min-h-80 bg-white px-4 py-4 dark:bg-gray-900">
                        <div class="prose max-w-none dark:prose-invert" x-html="body"></div>
                    </div>
                </div>
            </x-laravel-admin::admin.field>
        </div>
    </div>

    <div class="md:col-span-12 dark:border-white/10 mt-8 mb-6 border-b border-gray-900/10 sm:my-10"></div>

    <div class="md:col-span-4">
        <div class="flex flex-col">
            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">SEO</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">검색과 공유 링크에 사용할 메타 정보를 입력합니다.</p>
        </div>
    </div>

    <div class="mt-6 md:col-span-8 md:mt-0">
        <div class="space-y-5">
            <x-laravel-admin::admin.field name="meta_title" label="Meta title">
                <x-laravel-admin::admin.form-input id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}" class="w-full" />
            </x-laravel-admin::admin.field>

            <x-laravel-admin::admin.field name="meta_description" label="Meta description">
                <x-laravel-admin::admin.form-textarea id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $page->meta_description) }}</x-laravel-admin::admin.form-textarea>
            </x-laravel-admin::admin.field>

            <x-laravel-admin::admin.field name="canonical_url" label="Canonical URL">
                <x-laravel-admin::admin.form-input id="canonical_url" name="canonical_url" value="{{ old('canonical_url', $page->canonical_url) }}" class="w-full" />
            </x-laravel-admin::admin.field>

            <x-laravel-admin::admin.field name="og_title" label="OG title">
                <x-laravel-admin::admin.form-input id="og_title" name="og_title" value="{{ old('og_title', $page->og_title) }}" class="w-full" />
            </x-laravel-admin::admin.field>

            <x-laravel-admin::admin.field name="og_image_path" label="OG image path">
                <x-laravel-admin::admin.form-input id="og_image_path" name="og_image_path" value="{{ old('og_image_path', $page->og_image_path) }}" class="w-full" />
            </x-laravel-admin::admin.field>

            <x-laravel-admin::admin.field name="og_description" label="OG description">
                <x-laravel-admin::admin.form-textarea id="og_description" name="og_description" rows="3">{{ old('og_description', $page->og_description) }}</x-laravel-admin::admin.form-textarea>
            </x-laravel-admin::admin.field>
        </div>
    </div>

    <div class="md:col-span-12 dark:border-white/10 mt-8 mb-6 border-b border-gray-900/10 sm:my-10"></div>

    @if($showActions ?? true)
        <div class="col-span-full flex items-center justify-end gap-x-3">
            <x-laravel-admin::admin.action-button href="{{ route('page.admin.pages.index') }}" variant="secondary">
                취소
            </x-laravel-admin::admin.action-button>
            <x-laravel-admin::admin.action-button type="submit">
                저장
            </x-laravel-admin::admin.action-button>
        </div>
    @endif
</div>
